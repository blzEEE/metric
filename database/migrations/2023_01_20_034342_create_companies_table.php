<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Region;
use App\Models\CompanyType;
use App\Models\CompanyOwnership;
use App\Models\CompanyLevel;
use App\Models\CompanyBedCapacity;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Region::class)->constrained();
            $table->foreignIdFor(CompanyType::class)->nullable()->constrained();
            $table->foreignIdFor(CompanyOwnership::class)->nullable()->constrained();
            $table->foreignIdFor(CompanyLevel::class)->nullable()->constrained();
            $table->foreignIdFor(CompanyBedCapacity::class)->nullable()->constrained();
            $table->string('city', 50);
            $table->string('name', 255);
            $table->string('short_name', 50);
            $table->string('address', 255)->nullable();
            $table->string('director_position', 100)->nullable();
            $table->string('director_name', 100)->nullable();
            $table->boolean('is_emergency')->nullable();
            $table->date('date_begin_year');
            $table->date('date_begin_quarter');
            $table->date('date_begin_month');
            $table->timestamps();
        });

        DB::table('companies')->insert([
            'region_id' => 27,
            'company_type_id' => 1,
            'company_ownership_id' => null,
            'company_level_id' => null,
            'company_bed_capacity_id' => null,
            'city' => 'г. Красноярск',
            'name' => 'Краевое государственное бюджетное учреждение здравоохранения "Краевая клиническая больница"',
            'short_name' => 'КГБУЗ ККБ',
            'address' => '',
            'director_position' => '',
            'director_name' => '',
            'is_emergency' => false,
            'date_begin_year' => Carbon::create(2022, 1, 1, 0),
            'date_begin_quarter' => Carbon::create(2021, 10, 1, 0),
            'date_begin_month' => Carbon::create(2021, 11, 1, 0),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
