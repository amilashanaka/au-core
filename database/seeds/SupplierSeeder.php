<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Tue Jul 28 2020 20:33:06 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


include_once 'LegacyMigrationSeeder.php';

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Tenant;
use App\Agent;
use App\Supplier;


class SupplierSeeder extends LegacyMigrationSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Tenant::all() as $tenant) {
            $database_name = $tenant->data['db_name'];
            foreach (
                DB::connection($database_name)->select("select * from `Supplier Dimension`", []) as $legacy_data
            ) {


                if ($agent_data = DB::connection($database_name)->select(
                    "select * from `Agent Supplier Bridge` where `Agent Supplier Supplier Key`=? ", [$legacy_data->{'Supplier Key'}]
                )) {


                    $owner = 'agent';

                    if ($agent = Agent::where('legacy_id', $agent_data[0]->{'Agent Supplier Agent Key'})->first()) {
                        $owner_id = $agent->id;
                    }

                } else {
                    $owner    = 'tenant';
                    $owner_id = $tenant->id;
                }


                $supplier_settings = $this->fill_data(
                    [
                        'purchase_order_name.format'  => 'Supplier Order Public ID Format',
                        'purchase_order_name.counter' => 'Supplier Order Last Order ID',
                    ], $legacy_data
                );


                $supplier_data = [];


                $slug = Str::kebab(strtolower($legacy_data->{'Supplier Code'}));
                $slug = preg_replace('/&/', '', $slug);

                Supplier::firstOrCreate(
                    [
                        'slug'       => $slug,
                       
                    ], [
                        'owner_type' => $owner,
                        'owner_id'   => $owner_id,
                        'name'      => $legacy_data->{'Supplier Name'},
                        'legacy_id' => $legacy_data->{'Supplier Key'},
                        'settings'  => $supplier_settings,
                        'data'      => $supplier_data

                    ]
                );


            }
        }
    }
}
