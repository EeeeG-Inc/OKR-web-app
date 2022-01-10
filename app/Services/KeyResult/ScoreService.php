<?php

namespace App\Services\KeyResult;

use App\Enums\Quarter;

class ScoreService
{
    public function getScores(): array
    {
        return [
            '0' => 0,
            '0.1' => 0.1,
            '0.2' => 0.2,
            '0.3' => 0.3,
            '0.4' => 0.4,
            '0.5' => 0.5,
            '0.6' => 0.6,
            '0.7' => 0.7,
            '0.8' => 0.8,
            '0.9' => 0.9,
            '1' => 1,
        ];
    }
}