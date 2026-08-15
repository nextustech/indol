<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->string('type', 100);
            $table->date('investigation_date')->nullable();
            $table->longText('findings')->nullable();
            $table->string('facility', 255)->nullable();
            $table->timestamps();
            $table->tinyInteger('isDeleted')->default(0);
            $table->unsignedBigInteger('deletedBy')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigations');
    }
};
