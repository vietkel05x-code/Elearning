<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('instructor_id')->nullable()->after('category_id');
            
            $table->index('instructor_id', 'idx_course_instructor');
            
            $table->foreign('instructor_id', 'fk_course_instructor')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign('fk_course_instructor');
            $table->dropIndex('idx_course_instructor');
            $table->dropColumn('instructor_id');
        });
    }
};
