<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetricUnitSeeder extends Seeder
{
    static $metricUnits = [
        ['name' => 'случ.'],
        ['name' => '%'],
        ['name' => 'случ. на 1000 пац.'],
        ['name' => 'случ. на 1000 операц.'],
        ['name' => 'суток'],
        ['name' => 'случ. на 1000 трансфузий'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$metricUnits as $metricUnit) {
            DB::table('metric_units')->insert($metricUnit);
        }
    }
}
