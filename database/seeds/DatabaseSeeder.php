<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
     $this->call(TenantSeeder::class);
     $this->call(EmployeeSeeder::class);
     $this->call(AgentSeeder::class);
     $this->call(SupplierSeeder::class);
     $this->call(UserSeeder::class);
    }
}
