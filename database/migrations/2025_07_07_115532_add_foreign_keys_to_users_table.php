<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            // State
            $table->unsignedBigInteger('state_id')->nullable()->after('id');
            $table->foreign('state_id')->references('sid')->on('state')->onDelete('set null');

            // State
            $table->unsignedBigInteger('city_id')->nullable()->after('id');
            $table->foreign('city_id')->references('cityid')->on('city')->onDelete('set null');
            
            // Relation
            $table->unsignedBigInteger('profile_for')->nullable()->after('id');
            $table->foreign('profile_for')->references('ptid')->on('profile_types')->onDelete('set null');
            
            // Relation
            $table->unsignedBigInteger('education_id')->nullable()->after('id');
            $table->foreign('education_id')->references('eid')->on('educations')->onDelete('set null');
            
            // Relation
            $table->unsignedBigInteger('religion_id')->nullable()->after('id');
            $table->foreign('religion_id')->references('rid')->on('religions')->onDelete('set null');
            
            // Caste
            $table->unsignedBigInteger('caste_id')->nullable()->after('id');
            $table->foreign('caste_id')->references('cid')->on('castes')->onDelete('set null');
            
            // Occupation
            $table->unsignedBigInteger('occupation_id')->nullable()->after('id');
            $table->foreign('occupation_id')->references('oid')->on('occupations')->onDelete('set null');

            // Annual Income
            $table->unsignedBigInteger('annual_income_id')->nullable()->after('id');
            $table->foreign('annual_income_id')->references('aid')->on('annual_incomes')->onDelete('set null');

            // Job Type
            $table->unsignedBigInteger('job_type_id')->nullable()->after('id');
            $table->foreign('job_type_id')->references('jtid')->on('job_types')->onDelete('set null');

            // Company Type
            $table->unsignedBigInteger('company_type_id')->nullable()->after('id');
            $table->foreign('company_type_id')->references('ctid')->on('company_types')->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');

            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');

            $table->dropForeign(['religion_id']);
            $table->dropColumn('religion_id');

            $table->dropForeign(['caste_id']);
            $table->dropColumn('caste_id');

            $table->dropForeign(['job_type_id']);
            $table->dropColumn('job_type_id');

            $table->dropForeign(['occupation_id']);
            $table->dropColumn('occupation_id');

            $table->dropForeign(['company_type_id']);
            $table->dropColumn('company_type_id');

            $table->dropForeign(['annual_income_id']);
            $table->dropColumn('annual_income_id');
        });
    }
}