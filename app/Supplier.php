<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Tue Jul 28 2020 20:24:02 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $casts = [
        'settings' => 'array',
        'data' => 'array'

    ];


    public function tenants()
    {
        return $this->belongsToMany('App\Tenant')->withTimestamps();
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent');
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function supplier_owner()
    {
        return $this->morphOne('App\Supplier', 'owner');
    }
}
