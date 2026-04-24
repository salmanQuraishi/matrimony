<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('father_name')
                ->nullable()
                ->after('name');

            $table->string('mother_name')
                ->nullable()
                ->after('father_name');

            $table->integer('brothers')
                ->default(0)
                ->after('mother_name');

            $table->integer('sisters')
                ->default(0)
                ->after('brothers');

            $table->string('address')
                ->nullable()
                ->after('myself');

            $table->string('birthplace')
                ->nullable()
                ->after('dob');

            $table->string('complexion_id')
                ->nullable()
                ->after('state_id');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'father_name',
                'mother_name',
                'brothers',
                'sisters',
                'address',
                'birthplace',
                'complexion_id'
            ]);

        });
    }
};