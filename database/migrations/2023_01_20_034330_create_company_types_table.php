<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    static array $companyTypes = [
        ['id' => 1, 'name' => 'Больница'],
        ['id' => 2, 'name' => 'Центр (клиника), в том числе многопрофильный(ая)'],
        ['id' => 3, 'name' => 'Перинатальный центр / родильный дом'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_types', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 50);
        });

        foreach(self::$companyTypes as $companyType){
            DB::table('company_types')->insert($companyType);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_types');
    }
};
