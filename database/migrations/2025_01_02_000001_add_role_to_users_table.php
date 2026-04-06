<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('email'); // admin, employee, contractor
            $table->string('department')->nullable()->after('role');
            $table->string('employee_code')->nullable()->unique()->after('department');
            $table->string('access_level')->default('basic')->after('employee_code'); // basic, elevated, full
            $table->string('avatar')->nullable()->after('access_level');
            $table->boolean('is_active')->default(true)->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'department', 'employee_code', 'access_level', 'avatar', 'is_active']);
        });
    }
};
