<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Sun Jul 26 2020 23:12:46 GMT+0800 (Malaysia Time) Tioman, Malaysia
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateClockingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clockings', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('timesheet_id');
            $table->type('enum', 'In','Out');
            $table->dateTimeTz('clocked_at', 0);
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clockings');
    }
}
