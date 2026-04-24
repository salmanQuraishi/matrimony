<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complexions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hindi_name')->nullable();
            $table->enum('status', ['show', 'hide'])->default('show');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complexions');
    }
};