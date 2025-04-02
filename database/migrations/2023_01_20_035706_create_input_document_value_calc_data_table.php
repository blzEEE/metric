<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\InputDocumentValue;
use \App\Models\MetricCalcData;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_document_value_calc_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InputDocumentValue::class)->constrained();
            $table->foreignIdFor(MetricCalcData::class)->constrained('metric_calc_data');
            $table->float('value', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('input_document_value_calc_data');
    }
};
