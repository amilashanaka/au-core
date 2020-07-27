<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Sun Jul 26 2020 20:01:27 GMT+0800 (Malaysia Time) Tioman, Malaysia
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedSmallInteger('tenant_id');
            $table->enum('status',['Active','Disabled'])->default('Active');

            $table->string('handle');
            $table->enum('userable',['Employee','Contractor','Supplier','Agent'])->default('Employee');
            $table->unsignedMediumInteger('userable_id');

            $table->json('settings')->default(new Expression('(JSON_ARRAY())'));
            $table->json('data')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
            $table->unsignedMediumInteger('legacy_id');
            $table->index(['tenant_id', 'handle']);
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
        Schema::dropIfExists('users');
    }
}
