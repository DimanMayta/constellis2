<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ContentSeeder::class,
            LeaderSeeder::class,
            DivisionSeeder::class,
            ServiceCategorySeeder::class,
            ContractSeeder::class,
            TrainingSeeder::class,
            NewsArticleSeeder::class,
            PlatformSeeder::class,
        ]);
    }
}
