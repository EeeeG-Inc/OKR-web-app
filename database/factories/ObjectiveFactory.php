<?php

namespace Database\Factories;

use App\Models\Okr;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'objective' => $this->faker->realText(50),
            'score'     => $this->faker->randomFloat(1, 0, 1), //小数点第1までの0から1のランダムな浮動小数点
            'okr_id'    => Okr::factory(),
        ];
    }
}
