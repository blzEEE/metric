<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetricCalcData;
use Illuminate\Support\Facades\DB;

class MetricCalcDataSeeder extends Seeder
{

    static $metricCalcData = [
        ['id' => 1, 'metric_id' => 1, 'name' => 'Число выявленных вентилятор-ассоциированных пневмоний', 'var_name' => 'a'],
        ['id' => 2, 'metric_id' => 1, 'name' => 'Число дней на ИВЛ', 'var_name' => 'b'],

        ['id' => 3, 'metric_id' => 2, 'name' => 'Число выявленных катетер-ассоциированных инфекций кровотока', 'var_name' => 'a'],
        ['id' => 4, 'metric_id' => 2, 'name' => 'Число дней катетеризации', 'var_name' => 'b'],

        ['id' => 5, 'metric_id' => 3, 'name' => 'Число выявленных катетер-ассоциированных инфекций мочевыводящих путей', 'var_name' => 'a'],
        ['id' => 6, 'metric_id' => 3, 'name' => 'Число дней катетеризации', 'var_name' => 'b'],

        ['id' => 7, 'metric_id' => 4, 'name' => 'Число выявленных инфекций послеоперационных ран ИОХВ', 'var_name' => 'a'],
        ['id' => 8, 'metric_id' => 4, 'name' => 'Количество проведенных операций', 'var_name' => 'b'],

        ['id' => 9, 'metric_id' => 5, 'name' => 'Число выявленных инфекций при оказании мед. помощи', 'var_name' => 'a'],
        ['id' => 10, 'metric_id' => 5, 'name' => 'Количество случаев госпитализации', 'var_name' => 'b'],

        ['id' => 11, 'metric_id' => 6, 'name' => 'Количество эпизодов с превышением длительности', 'var_name' => 'a'],
        ['id' => 12, 'metric_id' => 6, 'name' => 'Общее количество эпизодов', 'var_name' => 'b'],

        ['id' => 13, 'metric_id' => 7, 'name' => 'Количество случаев инфекций', 'var_name' => 'a'],
        ['id' => 14, 'metric_id' => 7, 'name' => 'Общее количество операций', 'var_name' => 'b'],

        ['id' => 15, 'metric_id' => 8, 'name' => 'Количество случаев инфекций у новорожденных', 'var_name' => 'a'],
        ['id' => 16, 'metric_id' => 8, 'name' => 'Общее количество новорожденных', 'var_name' => 'b'],

        ['id' => 17, 'metric_id' => 9, 'name' => 'Количество случаев инфекций у родильниц', 'var_name' => 'a'],
        ['id' => 18, 'metric_id' => 9, 'name' => 'Общее количество родов', 'var_name' => 'b'],

        ['id' => 19, 'metric_id' => 10, 'name' => 'Количество случаев с необходимостью применения антибиотиков', 'var_name' => 'a'],
        ['id' => 20, 'metric_id' => 10, 'name' => 'Количество случаев с применением антибиотиков', 'var_name' => 'b'],
     ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$metricCalcData as $calcData) {
            DB::table('metric_calc_data')->insert($calcData);
        }
    }
}
