<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InputDocumentValueCalcData;
use Illuminate\Support\Facades\DB;

class InputDocumentValueCalcDataSeeder extends Seeder
{
    static $documentValueCalcData = [
        ['input_document_value_id' => 1, 'metric_calc_data_id' => 11, 'value' => '43'],
        ['input_document_value_id' => 1, 'metric_calc_data_id' => 12, 'value' => '980'],

        ['input_document_value_id' => 2, 'metric_calc_data_id' => 13, 'value' => '43'],
        ['input_document_value_id' => 2, 'metric_calc_data_id' => 14, 'value' => '980'],

        ['input_document_value_id' => 3, 'metric_calc_data_id' => 15, 'value' => '43'],
        ['input_document_value_id' => 3, 'metric_calc_data_id' => 16, 'value' => '980'],

        ['input_document_value_id' => 4, 'metric_calc_data_id' => 17, 'value' => '43'],
        ['input_document_value_id' => 4, 'metric_calc_data_id' => 18, 'value' => '980'],



        ['input_document_value_id' => 5, 'metric_calc_data_id' => 1, 'value' => '43'],
        ['input_document_value_id' => 5, 'metric_calc_data_id' => 2, 'value' => '980'],

        ['input_document_value_id' => 6, 'metric_calc_data_id' => 3, 'value' => '43'],
        ['input_document_value_id' => 6, 'metric_calc_data_id' => 4, 'value' => '980'],

        ['input_document_value_id' => 7, 'metric_calc_data_id' => 5, 'value' => '43'],
        ['input_document_value_id' => 7, 'metric_calc_data_id' => 6, 'value' => '980'],

        ['input_document_value_id' => 8, 'metric_calc_data_id' => 7, 'value' => '43'],
        ['input_document_value_id' => 8, 'metric_calc_data_id' => 8, 'value' => '980'],

        ['input_document_value_id' => 9, 'metric_calc_data_id' => 9, 'value' => '43'],
        ['input_document_value_id' => 9, 'metric_calc_data_id' => 10, 'value' => '980'],



        ['input_document_value_id' => 10, 'metric_calc_data_id' => 1, 'value' => '43'],
        ['input_document_value_id' => 10, 'metric_calc_data_id' => 2, 'value' => '980'],

        ['input_document_value_id' => 11, 'metric_calc_data_id' => 3, 'value' => '43'],
        ['input_document_value_id' => 11, 'metric_calc_data_id' => 4, 'value' => '980'],

        ['input_document_value_id' => 12, 'metric_calc_data_id' => 5, 'value' => '43'],
        ['input_document_value_id' => 12, 'metric_calc_data_id' => 6, 'value' => '980'],

        ['input_document_value_id' => 13, 'metric_calc_data_id' => 7, 'value' => '43'],
        ['input_document_value_id' => 13, 'metric_calc_data_id' => 8, 'value' => '980'],

        ['input_document_value_id' => 14, 'metric_calc_data_id' => 9, 'value' => '43'],
        ['input_document_value_id' => 14, 'metric_calc_data_id' => 10, 'value' => '980'],



        ['input_document_value_id' => 15, 'metric_calc_data_id' => 1, 'value' => '43'],
        ['input_document_value_id' => 15, 'metric_calc_data_id' => 2, 'value' => '980'],

        ['input_document_value_id' => 16, 'metric_calc_data_id' => 3, 'value' => '43'],
        ['input_document_value_id' => 16, 'metric_calc_data_id' => 4, 'value' => '980'],

        ['input_document_value_id' => 17, 'metric_calc_data_id' => 5, 'value' => '43'],
        ['input_document_value_id' => 17, 'metric_calc_data_id' => 6, 'value' => '980'],

        ['input_document_value_id' => 18, 'metric_calc_data_id' => 7, 'value' => '43'],
        ['input_document_value_id' => 18, 'metric_calc_data_id' => 8, 'value' => '980'],

        ['input_document_value_id' => 19, 'metric_calc_data_id' => 9, 'value' => '43'],
        ['input_document_value_id' => 19, 'metric_calc_data_id' => 10, 'value' => '980'],



        ['input_document_value_id' => 20, 'metric_calc_data_id' => 19, 'value' => '43'],
        ['input_document_value_id' => 20, 'metric_calc_data_id' => 20, 'value' => '980'],


        ['input_document_value_id' => 21, 'metric_calc_data_id' => 19, 'value' => '43'],
        ['input_document_value_id' => 21, 'metric_calc_data_id' => 20, 'value' => '980'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$documentValueCalcData as $calcData) {
            DB::table('input_document_value_calc_data')->insert($calcData);
        }
    }
}
