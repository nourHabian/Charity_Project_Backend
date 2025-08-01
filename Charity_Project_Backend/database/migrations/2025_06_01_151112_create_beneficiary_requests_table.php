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
            $table->string('phone_number');
            $table->enum('gender', ['ذكر', 'أنثى']);
            $table->integer('age');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->enum('marital_status', ['أعزب', 'متزوج', 'مطلق', 'أرمل']);
            $table->integer('number_of_kids')->default(0);
            $table->string('governorate');
            $table->text('kids_description')->nullable();
            $table->string('home_address');
            $table->float('monthly_income')->default(0);
            $table->string('current_job');
            $table->string('monthly_income_source');
            $table->integer('number_of_needy')->nullable();
            $table->float('expected_cost')->nullable();
            $table->text('description')->nullable();
            $table->enum('severity_level', ['منخفض', 'متوسط', 'مرتفع', 'حرج'])->default('متوسط');
            $table->string('document_path')->nullable();
            $table->enum('current_housing_condition', ['ملك', 'أجار', 'استضافة', 'لا يوجد سكن'])->nullable();
            $table->enum('needed_housing_help', ['إصلاحات منزلية', 'مساعدة في دفع الإيجار', 'تأمين سكن'])->nullable();
            $table->enum('status', ['معلق', 'مقبول', 'مرفوض'])->nullable()->default('معلق');
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
