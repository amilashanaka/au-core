<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Mon Jul 27 2020 17:38:26 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $database_names = preg_split('/,/', env('MIGRATION_DATABASE_NAMES'));
        $tenant_codes   = preg_split('/,/', env('MIGRATION_TENANT_CODES'));
        $legacy_codes   = preg_split('/,/', env('MIGRATION_ACCOUNT_LEGACY_CODES'));
       
        foreach ($tenant_codes as $index => $tenant_code) {
            Tenant::firstOrCreate(
                [
                    'slug' => Str::kebab($tenant_code),
                ], [

                    'data'     => [
                        'db_name'     => $database_names[$index],
                        'legacy_code' => $legacy_codes[$index],
                    ],
                    'settings' => [
                        'recover_email' => 'recover@inikoo.com',
                        'recover_pin'   => hash('crc32', rand(0, 10000))
                    ]
                ]
            );
        }

       
    }
}
