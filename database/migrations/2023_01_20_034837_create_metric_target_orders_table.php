<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMetricTargetOrdersTable extends Migration
{
    static $metricTargetOrders = [
        ['id' => 1, 'name' => 'Лучше, когда меньше', 'system_name' => 'asc'],
        ['id' => 2, 'name' => 'Лучше, когда больше', 'system_name' => 'desc'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metric_target_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 20);
            $table->string('system_name', 20);
        });

        foreach(self::$metricTargetOrders as $metricTargetOrder){
            DB::table('metric_target_orders')->insert($metricTargetOrder);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metric_target_orders');
    }
}
