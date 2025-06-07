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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_type');
            $table->string('name');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->float('total_amount');
            $table->float('current_amount');
            $table->enum('status', ['in_progress', 'on_hold', 'completed', 'cancelled'])->default('in_progress');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->nullable();
            $table->enum('duration_type', ['temporary', 'permanent', 'volunteer'])->default('temporary');
            $table->string('location')->nullable();
            $table->string('volunteer_hours')->nullable();
            $table->string('required_tasks')->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
