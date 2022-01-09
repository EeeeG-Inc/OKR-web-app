<?php

namespace Database\Factories;

use App\Models\Objective;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key_result' => $this->faker->realText(50),
            'score' => $this->faker->randomFloat(1, 0, 1), //小数点第1までの0から1のランダムな浮動小数点
            'objective_id' => Objective::factory(),
        ];
    }
}
