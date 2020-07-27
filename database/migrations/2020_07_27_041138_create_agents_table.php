<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Mon Jul 27 2020 12:14:43 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->json('settings')->default(new Expression('(JSON_ARRAY())'));
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
            $table->unsignedMediumInteger('legacy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
