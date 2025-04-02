<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetricCategoryUser;
use Illuminate\Support\Facades\DB;

class MetricCategoryUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metric_category_user')->insert([
            'user_id' => 3,
            'metric_category_id' => 1
        ]);
    }
}
