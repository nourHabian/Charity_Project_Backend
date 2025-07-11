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
            $table->string('full_name');
            $table->string('phone_number')->unique();
            $table->enum('gender', ['ذكر', 'أنثى']);
            $table->integer('age');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->enum('marital_status', ['أعزب', 'متزوج', 'مطلق', 'أرمل']);
            $table->integer('number_of_kids')->default(0);
            $table->string('city');
            $table->text('kids_description');
            $table->string('home_address');
            $table->float('monthly_income')->default(0);
            $table->string('current_job');
            $table->string('monthly_income_source');
            $table->enum('is_taking_donations',['لا','نعم']);
            $table->string('other_donations_sources')->nullable();
            $table->integer('number_of_needy')->nullable();
            $table->float('expected_cost')->nullable();
            $table->text('description')->nullable();
            $table->enum('severity_level', ['منخفض', 'متوسط', 'مرتفع', 'حرج'])->default('متوسط');
            $table->string('document_path')->nullable();
            $table->enum('current_housing_condition', ['ملك', 'أجار', 'استضافة'])->nullable();
            $table->string('host_address')->nullable();
            $table->string('host_number')->nullable();
            $table->enum('volunteer_status', ['معلق', 'مقبول', 'مرفوض'])->nullable()->default('معلق');
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
