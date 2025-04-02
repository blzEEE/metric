<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    static $roles = [
        ['id' => 1, 'name' => 'Администратор системы', 'is_require_company' => false],
        ['id' => 2, 'name' => 'Наблюдатель', 'is_require_company' => false],
        ['id' => 3, 'name' => 'Администратор организации', 'is_require_company' => true],
        ['id' => 4, 'name' => 'Оператор', 'is_require_company' => true]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 50);
            $table->boolean('is_require_company');
        });

        foreach(self::$roles as $role){
            DB::table('user_roles')->insert($role);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
};
