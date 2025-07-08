<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->boolean('verified')->default(false);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['ذكر', 'أنثى'])->nullable();
            $table->integer('age')->nullable();
            $table->enum('role', ['متبرع', 'مستفيد', 'متطوع']);
            $table->float('balance')->default(0);
            $table->bigInteger('points')->default(0);
            $table->date('beneficiary_last_order')->nullable();
            $table->enum('beneficiary_status', ['معلق', 'مقبول', 'مرفوض', 'منتهي'])->nullable(); // منتهي يعني تم توصيل الطلب
            $table->float('monthly_donation')->default(0);
            $table->enum('monthly_donation_type', ['صحي', 'تعليمي', 'سكني', 'غذائي'])->default('صحي');
            $table->boolean('ban')->default(false);
            $table->enum('volunteer_status', ['معلق', 'مقبول', 'مرفوض'])->nullable();
            $table->enum('volunteering_domain', ['صحي', 'تعليمي', 'عن بعد','ميداني'])->nullable();
            $table->boolean('is_working')->default(false);
            $table->string('purpose_of_volunteering')->nullable();
            $table->string('place_of_residence')->nullable();
            $table->integer('volunteering_hours')->nullable();
            $table->enum('your_last_educational_qualification', ['معهد متوسط /دبلوم ', 'طالب جامعي', ' بكالوريوس','ماجستير'])->nullable();
            $table->string('your_studying_domain')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /* Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
