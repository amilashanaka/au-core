<?php
/*
Author: Raul Perusquia (raul@inikoo.com)
Created:  Tue Jul 28 2020 21:55:24 GMT+0800 (Malaysia Time) Tioman, Malaysia 
Copyright (c) 2020, Raúl Alejandro Perusquía Flores

Version 4
*/


include_once 'LegacyMigrationSeeder.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Tenant;
use App\Agent;
use App\Employee;
use App\User;


class UserSeeder extends LegacyMigrationSeeder
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
            foreach (DB::connection($database_name)->select("select * from`User Dimension`", []) as $legacy_data) {


                if (!($legacy_data->{'User Type'} == 'Administrator' or $legacy_data->{'User Type'} == 'Warehouse')) {

                    $user_parent_key = null;
                    switch ($legacy_data->{'User Type'}) {
                        case 'Staff':
                            $user_parent = 'employee';
                            if ($employee = Employee::where('legacy_id', $legacy_data->{'User Parent Key'})->where('tenant_id', $tenant->id)->first()) {
                                $user_parent_key = $employee->id;
                            }
                            break;
                        case 'Contractor':
                            $user_parent = 'contractor';
                            if ($employee = Employee::where('legacy_id', $legacy_data->{'User Parent Key'})->where('tenant_id', $tenant->id)->first()) {
                                $user_parent_key = $employee->id;
                            }
                            break;
                        case 'Agent':
                            $user_parent = 'agent';
                            if ($agent = Agent::where('legacy_id', $legacy_data->{'User Parent Key'})->first()) {
                                $user_parent_key = $agent->id;
                            }
                            break;
                        default:
                            $user_parent = $legacy_data->{'User Type'};
                    }

                    $user_settings = [];

                    $user_data = $this->fill_data(
                        [
                            'pwd_legacy' => 'User Password'
                        ],
                        $legacy_data
                    );



                    User::firstOrCreate(
                        [
                            'tenant_id' => $tenant->id,
                            'handle'    => $legacy_data->{'User Handle'},
                        ],
                        [
                            'password' => bcrypt($legacy_data->{'User Password'}),
                            'legacy_id'   => $legacy_data->{'User Key'},
                            'userable'    => $user_parent,
                            'userable_id' => $user_parent_key,
                            'status'      => ($legacy_data->{'User Active'} == 'Yes' ? 'Active' : 'Disabled'),
                            'settings'    => $user_settings,
                            'data'        => $user_data

                        ]
                    );
                }
            }
        }
    }
}
