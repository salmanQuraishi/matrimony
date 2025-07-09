<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profile_types', function (Blueprint $table) {
            $table->bigIncrements('ptid');
            $table->string('name')->unique();
            $table->enum('status', ['show', 'hide'])->default('show');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile_types');
    }
};