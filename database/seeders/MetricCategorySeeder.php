<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetricCategorySeeder extends Seeder
{
    static $metricCategories = [
        ['id' => 1, 'name' => 'Эпидемиологическая безопасность (профилактика инфекций, связанных с осуществлением медицинской деятельности)'],
        ['id' => 2, 'name' => 'Безопасность при организации экстренной и неотложной помощи'],
        ['id' => 3, 'name' => 'Преемственность оказания медицинской помощи'],
        ['id' => 4, 'name' => 'Хирургическая безопасность, профилактика рисков, связанных с оперативными вмешательствами'],
        ['id' => 5, 'name' => 'Профилактика рисков, связанных с переливанием донорской крови и ее компонентов, препаратов из донорской крови'],
        ['id' => 6, 'name' => 'Безопасность при организации ухода за пациентами, в том числе профилактики пролежней и падений'],
        ['id' => 7, 'name' => 'Управление сотрудниками при осуществлении медицинской деятельности'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$metricCategories as $metricCategory){
            DB::table('metric_categories')->insert($metricCategory);
        }
    }
}
