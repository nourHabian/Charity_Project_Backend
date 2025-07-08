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
        Schema::create('charities', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_donations')->default(0);
            $table->integer('number_of_beneficiaries')->default(0);
            $table->float('health_projects_balance')->default(0);
            $table->float('educational_projects_balance')->default(0);
            $table->float('nutritional_projects_balance')->default(0);
            $table->float('housing_projects_balance')->default(0);
            $table->float('religious_projects_balance')->default(0);
            $table->date('last_monthly_donation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charities');
    }
};
