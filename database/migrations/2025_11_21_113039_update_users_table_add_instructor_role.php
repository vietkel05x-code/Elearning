<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cập nhật enum role để thêm 'instructor'
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('student', 'instructor', 'admin') NOT NULL DEFAULT 'student'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert về enum cũ
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('student', 'admin') NOT NULL DEFAULT 'student'");
    }
};
