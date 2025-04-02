<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    static array $companyOwnerships = [
        ['id' => 1, 'name' => 'Государственная'],
        ['id' => 2, 'name' => 'Частная'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_ownerships', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 50);
        });

        foreach(self::$companyOwnerships as $companyOwnership){
            DB::table('company_ownerships')->insert($companyOwnership);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_ownerships');
    }
};
