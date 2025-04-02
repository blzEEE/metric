<?php

use App\Models\Metric;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricCalcDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metric_calc_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Metric::class)->constrained();
            $table->string('name', 255);
            $table->char('var_name', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metric_calc_data');
    }
}
