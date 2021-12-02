<?php

namespace Database\Factories;

use App\Models\Quarter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OkrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'okr'       => $this->faker->realText(10),
            'score'      => $this->faker->randomFloat(1, 0, 1), //小数点第1までの0から1のランダムな浮動小数点
            'user_id'    => User::factory(),
            'year'       => $this->faker->year(),
            'quarter_id' => Quarter::factory(),
        ];
    }
}
