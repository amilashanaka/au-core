<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Tue Jul 28 2020 20:16:52 GMT+0800 (Malaysia Time) Kuala Lumpur, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/

include_once 'LegacyMigrationSeeder.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Tenant;
use App\Agent;

class AgentSeeder extends LegacyMigrationSeeder
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
                DB::connection($database_name)->select("select * from`Agent Dimension`", []) as $legacy_data
            ) {


                $agent_settings = $this->fill_data(
                    [
                        'purchase_order_name.format'  => 'Agent Order Public ID Format',
                        'purchase_order_name.counter' => 'Agent Order Last Order ID',
                    ], $legacy_data
                );


                $agent_data = [];


                $slug = Str::kebab(strtolower($legacy_data->{'Agent Code'}));
                $slug = preg_replace('/&/', '', $slug);

                $agent = Agent::firstOrCreate(
                    [
                        'slug' => $slug,

                    ], [
                        'name'      => $legacy_data->{'Agent Name'},
                        'legacy_id' => $legacy_data->{'Agent Key'},
                        'settings'  => $agent_settings,
                        'data'      => $agent_data

                    ]
                );

                if(!$agent->tenants()->where('tenant_id', $tenant->id)->count()){
                    $agent->tenants()->attach($tenant->id);
                }
                
                


            }
        }
    }
}
