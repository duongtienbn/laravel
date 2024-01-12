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
        //
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->string('name_kana', 500)->nullable();
            $table->boolean('sex')->default(0)->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedInteger('age')->length(10)->default(0)->nullable();
            $table->string('country', 500)->nullable();

            $table->date('first_interv_date')->nullable();
            $table->string('first_interv_staff', 500)->nullable();
            $table->boolean('first_interv_result')->nullable();

            $table->date('sec_interv_date')->nullable();
            $table->string('sec_interv_staff', 500)->nullable();
            $table->boolean('sec_interv_result')->nullable();

            $table->date('intern_interv_date')->nullable();
            $table->string('intern_department', 500)->nullable();
            $table->boolean('intern_result')->nullable();
            $table->date('hire_date')->nullable();

            $table->string('phone')->unique()->nullable();
            $table->string('email', 500)->unique()->nullable();

            $table->unsignedInteger('skill_jlpt')->length(5)->nullable();
            $table->unsignedInteger('skill_hearing')->length(5)->nullable();
            $table->unsignedInteger('skill_speaking')->length(5)->nullable();
            $table->unsignedInteger('skill_reading')->length(5)->nullable();
            $table->string('skill_se', 500)->nullable();

            $table->boolean('graduate_4')->nullable();
            $table->boolean('graduate_2')->nullable();
            $table->string('graduate_school', 500)->nullable();

            $table->string('apply_department', 500)->nullable();
            $table->string('working_place', 500)->nullable();
            $table->string('current_status', 500)->nullable();
            $table->string('note', 500)->nullable();
            $table->string('folder_name', 20)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('students');
    }
};
