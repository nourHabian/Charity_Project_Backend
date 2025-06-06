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
        Schema::create('beneficiary_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->integer('number_of_kids')->default(0);
            $table->string('city');
            $table->text('kids_description');
            $table->string('home_address');
            $table->float('monthly_income')->default(0);
            $table->string('current_job');
            $table->string('monthly_income_source');
            $table->boolean('is_taking_donations')->default(false);
            $table->string('other_donations_sources')->nullable();
            $table->integer('number_of_needy')->nullable();
            $table->float('expected_cost')->nullable();
            $table->text('description');
            $table->enum('severity_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('document_path')->nullable();
            $table->enum('current_housing_condition', ['own', 'rent', 'hosted'])->nullable();
            $table->string('host_address')->nullable();
            $table->string('host_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_requests');
    }
};
