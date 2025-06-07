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
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->float('total_amount');
            $table->float('current_amount');
            $table->enum('status', ['جاري', 'معلق', 'منتهي', 'ملغى'])->default('جاري');
            $table->enum('priority', ['منخفض', 'متوسط', 'مرتفع', 'حرج'])->default('متوسط');
            $table->enum('duration_type', ['مؤقت', 'دائم', 'تطوعي', 'فردي'])->default('مؤقت');
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
