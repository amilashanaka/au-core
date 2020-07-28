<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Tue Jul 28 2020 19:56:27 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Tenant;



class LegacyMigrationSeeder extends Seeder
{

    public function fill_data($fields, $legacy_data) {

        $data = [];
        foreach ($fields as $key => $legacy_key) {


            if (!empty($legacy_data->{$legacy_key})) {

                $key_path = preg_split('/\./', $key);
                if (count($key_path) == 1) {
                    $data[$key] = $legacy_data->{$legacy_key};
                } elseif (count($key_path) == 2) {
                    $data[$key_path[0]][$key_path[1]] = $legacy_data->{$legacy_key};
                } elseif (count($key_path) == 3) {
                    $data[$key_path[0]][$key_path[1]][$key_path[2]] = $legacy_data->{$legacy_key};
                }


            }
        }

        return $data;
    }

    public function add_connection_for_legacy_databases() {

        $database_settings = data_get(config('database.connections'), 'mysql');

        foreach (Tenant::all() as $tenant) {


            $database_name     = $tenant->data['db_name'];
            data_set($database_settings, 'database', $database_name);
            config(['database.connections.'.$database_name=>$database_settings]);
           


            DB::connection($database_name);
        }
    }

}
