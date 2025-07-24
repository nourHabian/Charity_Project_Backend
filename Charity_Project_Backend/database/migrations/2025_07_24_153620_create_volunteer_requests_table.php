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
        Schema::create('volunteer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('phone_number');
            $table->enum('gender', ['ذكر', 'أنثى']);
            $table->integer('age');
            $table->enum('volunteer_status', ['معلق', 'مقبول', 'مرفوض'])->default('معلق');
            $table->string('purpose_of_volunteering');
            $table->string('place_of_residence');
            $table->integer('volunteering_hours');
            $table->enum('your_last_educational_qualification', ['معهد متوسط /دبلوم ', 'طالب جامعي', ' بكالوريوس', 'ماجستير']);
            $table->string('your_studying_domain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_requests');
    }
};
