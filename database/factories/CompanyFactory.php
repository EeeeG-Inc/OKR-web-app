<?php

namespace Database\Factories;

use App\Models\CompanyGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'company_group_id' => CompanyGroup::factory(),
            'is_master' => $this->faker->boolean(50),
        ];
    }
}
