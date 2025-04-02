<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputDocumentSeeder extends Seeder
{
    static $inputDocuments = [
        ["id" => 1, "company_id" => 1, "user_id" => 2, "metric_category_id" => 1, "input_document_status_id" => 2, "metric_period_id" => 1, "year" => 2022, "quarter" => 0, "month" => 0, "created_at" => "2023-03-09"],
        ["id" => 2, "company_id" => 1, "user_id" => 2, "metric_category_id" => 1, "input_document_status_id" => 2, "metric_period_id" => 2, "year" => 2022, "quarter" => 1, "month" => 0, "created_at" => "2023-03-09"],
        ["id" => 3, "company_id" => 1, "user_id" => 2, "metric_category_id" => 1, "input_document_status_id" => 1, "metric_period_id" => 2, "year" => 2022, "quarter" => 2, "month" => 0, "created_at" => "2023-03-09"],
        ["id" => 4, "company_id" => 1, "user_id" => 2, "metric_category_id" => 1, "input_document_status_id" => 1, "metric_period_id" => 2, "year" => 2022, "quarter" => 3, "month" => 0, "created_at" => "2023-03-09"],
        ["id" => 5, "company_id" => 1, "user_id" => 2, "metric_category_id" => 1, "input_document_status_id" => 2, "metric_period_id" => 3, "year" => 2022, "quarter" => 1, "month" => 1, "created_at" => "2023-03-09"],
        ["id" => 6, "company_id" => 1, "user_id" => 2, "metric_category_id" => 1, "input_document_status_id" => 1, "metric_period_id" => 3, "year" => 2022, "quarter" => 1, "month" => 2, "created_at" => "2023-03-09"],
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$inputDocuments as $inputDocument){
            DB::table('input_documents')->insert($inputDocument);
        }
    }
}
