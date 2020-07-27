<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Mon Jul 27 2020 13:13:31 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTenantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_tenant', function (Blueprint $table) {
            $table->unsignedMediumInteger('supplier_id');
            $table->unsignedMediumInteger('tenant_id');
            $table->timestamps();
            $table->primary(['supplier_id','tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_tenant');
    }
}
