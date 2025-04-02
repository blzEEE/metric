<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    static array $companyBedCapacities = [
        ['id' => 1, 'name' => 'свыше 800'],
        ['id' => 2, 'name' => '400 - 800'],
        ['id' => 3, 'name' => '200 - 399'],
        ['id' => 4, 'name' => '100 - 199'],
        ['id' => 5, 'name' => 'менее 100'],
    ];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_bed_capacities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 50);
        });

        foreach(self::$companyBedCapacities as $companyBedCapacity){
            DB::table('company_bed_capacities')->insert($companyBedCapacity);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_bed_capacities');
    }
};
