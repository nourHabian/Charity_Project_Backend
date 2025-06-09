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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('types')->cascadeOnDelete();
            $table->string('phone_number');
            $table->integer('age');
            $table->string('purpose_of_volunteering');
            $table->string('current_location');
            $table->integer('volunteering_hours');
             $table->enum('gender', ['ذكر', 'أنثى']);
             $table->enum('volunteering_domain', ['تعليمي', 'صحي','عن بعد','ميداني']);
             $table->enum('education', ['جامعي', 'ثانوي','دراسات عليا']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
