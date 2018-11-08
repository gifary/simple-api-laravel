<?php

use Illuminate\Database\Seeder;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $package = new \App\Models\Package();
        $package->name = "Standard Package";
        $package->cost = 30000;
        $package->maximum_dvd=20;
        $package->save();

        $package = new \App\Models\Package();
        $package->name = "Premium Package";
        $package->cost = 50000;
        $package->maximum_dvd=40;
        $package->save();
    }
}
