<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Mon Jul 27 2020 12:13:40 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('tenant_id');
            $table->enum('status',['Working','NotWorking'])->default('Working');
            $table->string('slug');
            $table->string('name');
            $table->json('settings')->default(new Expression('(JSON_ARRAY())'));
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
            $table->unsignedMediumInteger('legacy_id');
            $table->index(['tenant_id', 'slug']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
