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
            $table->string('name');
            $table->text('description');
            $table->string('photo');
            $table->float('total_amount');
            $table->float('current_amount');
            $table->enum('status', ['in_progress', 'on_hold', 'completed', 'cancelled'])->default('in_progress');
            $table->enum('priority', ['low', 'medium', 'high', 'critical']);
            $table->boolean('accepts_volunteers')->default(false);
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
