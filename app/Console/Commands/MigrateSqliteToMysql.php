<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateSqliteToMysql extends Command
{
    protected $signature = 'app:migrate-sqlite-to-mysql
                            {--sqlite-path= : Path to the SQLite database file}
                            {--force : Skip confirmation prompt}';

    protected $description = 'Migrate all data from SQLite database to MySQL (current connection)';

    // Tables to skip (Laravel internal or migration-managed)
    protected array $skipTables = [
        'migrations',
        'password_reset_tokens',
        'sessions',
        'cache',
        'cache_locks',
        'jobs',
        'job_batches',
        'failed_jobs',
        'personal_access_tokens',
    ];

    public function handle(): int
    {
        $sqlitePath = $this->option('sqlite-path')
            ?? database_path('database.sqlite');

        if (!file_exists($sqlitePath)) {
            $this->error("SQLite database not found at: {$sqlitePath}");
            return self::FAILURE;
        }

        $this->info("╔══════════════════════════════════════════╗");
        $this->info("║   SQLite → MySQL Data Migration Tool     ║");
        $this->info("╚══════════════════════════════════════════╝");
        $this->newLine();

        // Configure SQLite connection on the fly
        config(['database.connections.sqlite_source' => [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]]);

        $sqlite = DB::connection('sqlite_source');

        // Get all tables from SQLite
        $tables = collect($sqlite->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'"))
            ->pluck('name')
            ->filter(fn ($t) => !in_array($t, $this->skipTables))
            ->values();

        $this->info("📂 SQLite database: {$sqlitePath}");
        $this->info("🗄️  MySQL database: " . config('database.connections.mysql.database'));
        $this->info("📋 Tables found: {$tables->count()}");
        $this->newLine();

        if (!$this->option('force') && !$this->confirm('This will INSERT data into your MySQL database. Continue?')) {
            $this->warn('Aborted.');
            return self::SUCCESS;
        }

        // Disable foreign key checks during import
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $totalRows = 0;
        $errors = [];

        $this->withProgressBar($tables, function ($table) use ($sqlite, &$totalRows, &$errors) {
            try {
                // Check if table exists in MySQL
                if (!Schema::hasTable($table)) {
                    $errors[] = "⚠️  Table '{$table}' does not exist in MySQL — skipped";
                    return;
                }

                // Get all rows from SQLite
                $rows = $sqlite->table($table)->get();

                if ($rows->isEmpty()) {
                    return;
                }

                // Clear existing data in MySQL table
                DB::table($table)->truncate();

                // Insert in chunks of 100
                $chunks = $rows->chunk(100);
                foreach ($chunks as $chunk) {
                    $data = $chunk->map(fn ($row) => (array) $row)->toArray();
                    DB::table($table)->insert($data);
                }

                $totalRows += $rows->count();
            } catch (\Exception $e) {
                $errors[] = "❌ Table '{$table}': " . $e->getMessage();
            }
        });

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->newLine(2);

        // Report results
        if (!empty($errors)) {
            $this->warn('⚠️  Some issues occurred:');
            foreach ($errors as $error) {
                $this->line("   {$error}");
            }
            $this->newLine();
        }

        $this->info("✅ Migration complete!");
        $this->info("   📊 Tables processed: {$tables->count()}");
        $this->info("   📝 Total rows migrated: {$totalRows}");

        // Summary table
        $this->newLine();
        $summaryData = [];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                if ($count > 0) {
                    $summaryData[] = [$table, $count];
                }
            }
        }

        if (!empty($summaryData)) {
            $this->table(['Table', 'Rows'], $summaryData);
        }

        return self::SUCCESS;
    }
}
