<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('assessed_by')->constrained('users');
            $table->dateTime('assessment_date');
            $table->enum('type', ['initial', 'follow-up', 'discharge'])->default('initial');
            $table->longText('chief_complaints')->nullable();
            $table->longText('history_of_present_illness')->nullable();
            $table->longText('observation')->nullable();
            $table->longText('palpation')->nullable();
            $table->longText('range_of_motion')->nullable();
            $table->longText('muscle_strength')->nullable();
            $table->longText('special_tests')->nullable();
            $table->longText('neurological')->nullable();
            $table->longText('postural_assessment')->nullable();
            $table->longText('clinical_impression')->nullable();
            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->timestamps();
            $table->tinyInteger('isDeleted')->default(0);
            $table->unsignedBigInteger('deletedBy')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
