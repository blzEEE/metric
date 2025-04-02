<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    static array $companyLevels = [
        ['id' => 1, 'name' => 'Федеральная'],
        ['id' => 2, 'name' => 'Краевая / республиканская / областная / окружная'],
        ['id' => 3, 'name' => 'Межрайонная'],
        ['id' => 4, 'name' => 'Районная'],
        ['id' => 5, 'name' => 'Городская'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_levels', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 50);
        });

        foreach(self::$companyLevels as $companyLevel){
            DB::table('company_levels')->insert($companyLevel);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_levels');
    }
};
