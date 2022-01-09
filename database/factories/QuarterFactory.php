<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuarterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quarter' => 1,
            'from' => $this->faker->month(),
            'to' => $this->faker->month(),
            'company_id' => Company::factory(),
        ];
    }
}
