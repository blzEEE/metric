<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InputDocumentValue;
use Illuminate\Support\Facades\DB;

class InputDocumentValueSeeder extends Seeder
{
    static $inputDocumentValues = [
        ['id' => 1, 'input_document_id' => 1, 'metric_id' => 6, 'value' => '0.7', 'is_active' => true],
        ['id' => 2, 'input_document_id' => 1, 'metric_id' => 7, 'value' => '0.25', 'is_active' => true],
        ['id' => 3, 'input_document_id' => 1, 'metric_id' => 8, 'value' => null, 'is_active' => false],
        ['id' => 4, 'input_document_id' => 1, 'metric_id' => 9, 'value' => '50', 'is_active' => true],

        ['id' => 5, 'input_document_id' => 2, 'metric_id' => 1, 'value' => '0.7', 'is_active' => true],
        ['id' => 6, 'input_document_id' => 2, 'metric_id' => 2, 'value' => '0.25', 'is_active' => true],
        ['id' => 7, 'input_document_id' => 2, 'metric_id' => 3, 'value' => null, 'is_active' => false],
        ['id' => 8, 'input_document_id' => 2, 'metric_id' => 4, 'value' => '50', 'is_active' => true],
        ['id' => 9, 'input_document_id' => 2, 'metric_id' => 5, 'value' => '50', 'is_active' => true],

        ['id' => 10, 'input_document_id' => 3, 'metric_id' => 1, 'value' => '0.7', 'is_active' => true],
        ['id' => 11, 'input_document_id' => 3, 'metric_id' => 2, 'value' => '0.25', 'is_active' => true],
        ['id' => 12, 'input_document_id' => 3, 'metric_id' => 3, 'value' => null, 'is_active' => false],
        ['id' => 13, 'input_document_id' => 3, 'metric_id' => 4, 'value' => '50', 'is_active' => true],
        ['id' => 14, 'input_document_id' => 3, 'metric_id' => 5, 'value' => '50', 'is_active' => true],

        ['id' => 15, 'input_document_id' => 4, 'metric_id' => 1, 'value' => '0.7', 'is_active' => true],
        ['id' => 16, 'input_document_id' => 4, 'metric_id' => 2, 'value' => '0.25', 'is_active' => true],
        ['id' => 17, 'input_document_id' => 4, 'metric_id' => 3, 'value' => null, 'is_active' => false],
        ['id' => 18, 'input_document_id' => 4, 'metric_id' => 4, 'value' => '50', 'is_active' => true],
        ['id' => 19, 'input_document_id' => 4, 'metric_id' => 5, 'value' => '50', 'is_active' => true],

        ['id' => 20, 'input_document_id' => 5, 'metric_id' => 10, 'value' => '50', 'is_active' => true],

        ['id' => 21, 'input_document_id' => 6, 'metric_id' => 10, 'value' => '50', 'is_active' => true],

     ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$inputDocumentValues as $inputDocumentValue) {
            DB::table('input_document_values')->insert($inputDocumentValue);
        }
    }
}
