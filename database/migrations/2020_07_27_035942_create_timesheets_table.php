<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Mon Jul 27 2020 12:13:24 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('tenant_id');
            $table->date('date');
            $table->unsignedMediumInteger('employee_id');
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
            $table->unique(['date','employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheets');
    }
}
