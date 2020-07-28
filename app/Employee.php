<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Mon Jul 27 2020 19:53:46 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $casts = [
        'settings' => 'array',
        'data'     => 'array'
    ];
}
