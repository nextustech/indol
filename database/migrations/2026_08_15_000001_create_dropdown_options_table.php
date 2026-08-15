<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dropdown_options', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('name', 255);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->tinyInteger('isDeleted')->default(0);
            $table->unsignedBigInteger('deletedBy')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->unique(['type', 'name']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dropdown_options');
    }
};