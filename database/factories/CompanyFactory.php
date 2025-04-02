<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\CompanyBedCapacity;
use App\Models\CompanyLevel;
use App\Models\CompanyOwnership;
use App\Models\CompanyType;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "region_id" => Region::get()->random()->id,
            'company_type_id' => CompanyType::get()->random()->id,
            'company_ownership_id' => CompanyOwnership::get()->random()->id,
            'company_level_id' => CompanyLevel::get()->random()->id,
            'company_bed_capacity_id' => CompanyBedCapacity::get()->random()->id,
            "city" => $this->faker->city(),
            "name" => $this->faker->company(),
            "short_name" => $this->faker->company(),
            "address" => $this->faker->streetAddress(),
            "director_position" => $this->faker->jobTitle(),
            "director_name" => $this->faker->userName(),
            "is_emergency" => $this->faker->boolean(),
            "date_begin_year" => $this->faker->date(),
            "date_begin_quarter" => $this->faker->date(),
            "date_begin_month" => $this->faker->date(),
        ];
    }
}
