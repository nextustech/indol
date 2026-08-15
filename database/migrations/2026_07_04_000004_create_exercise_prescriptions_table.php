<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercise_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_plan_id')->constrained()->onDelete('cascade');
            $table->string('exercise_name', 255);
            $table->longText('description')->nullable();
            $table->enum('category', ['stretching', 'strengthening', 'mobilization', 'stabilization', 'balance', 'gait', 'postural', 'breathing', 'other'])->default('other');
            $table->string('sets', 50)->nullable();
            $table->string('repetitions', 50)->nullable();
            $table->string('frequency', 100)->nullable();
            $table->string('duration', 100)->nullable();
            $table->longText('precautions')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->tinyInteger('isDeleted')->default(0);
            $table->unsignedBigInteger('deletedBy')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_prescriptions');
    }
};
