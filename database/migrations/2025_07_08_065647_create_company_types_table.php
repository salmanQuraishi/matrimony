<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTypesTable extends Migration
{
    public function up()
    {
        Schema::create('company_types', function (Blueprint $table) {
            $table->bigIncrements('ctid');
            $table->string('name');
            $table->enum('status', ['show', 'hide'])->default('show');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_types');
    }
}