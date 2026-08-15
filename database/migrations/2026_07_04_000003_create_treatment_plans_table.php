<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->longText('short_term_goals')->nullable();
            $table->longText('long_term_goals')->nullable();
            $table->longText('precautions')->nullable();
            $table->longText('advice')->nullable();
            $table->longText('follow_up_instructions')->nullable();
            $table->enum('status', ['active', 'completed', 'discontinued'])->default('active');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->tinyInteger('isDeleted')->default(0);
            $table->unsignedBigInteger('deletedBy')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_plans');
    }
};
