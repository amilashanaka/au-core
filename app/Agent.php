<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Tue Jul 28 2020 20:22:23 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $casts = [
        'settings' => 'array',
        'data'     => 'array'
    ];

    public function tenants()
    {
        return $this->belongsToMany('App\Tenant')->withTimestamps();
    }

    public function suppliers()
    {
        return $this->hasMany('App\Supplier');
    }
}
