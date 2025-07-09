<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualIncomesTable extends Migration
{
    public function up()
    {
        Schema::create('annual_incomes', function (Blueprint $table) {
            $table->bigIncrements('aid');
            $table->string('range');
            $table->enum('status', ['show', 'hide'])->default('show');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('annual_incomes');
    }
}