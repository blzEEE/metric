<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Metric;
use App\Models\MetricCategory;
use App\Models\MetricCategoryUser;
use App\Models\InputDocument;
use App\Models\InputDocumentValue;
use App\Models\MetricUnit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\MetricCategorySeeder;
use Database\Seeders\MetricCategoryUserSeeder;
use Database\Seeders\InputDocumentSeeder;
use Database\Seeders\InputDocumentValueSeeder;
use Database\Seeders\MetricSeeder;
use Database\Seeders\MetricUnitSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            UserSeeder::class,
            MetricCategorySeeder::class,
            MetricCategoryUserSeeder::class,
            MetricUnitSeeder::class,
            MetricSeeder::class,
            MetricCalcDataSeeder::class,
            InputDocumentSeeder::class,
            InputDocumentValueSeeder::class,
            InputDocumentValueCalcDataSeeder::class
        ]);
    }
}
