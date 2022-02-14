<?php

namespace App\Services\YMD;

class MonthService
{
    public function createMonthsArray(): array
    {
        $months = [];
        $i = 1;
        while ($i < 13) {
            $months[$i] = $i;
            $i++;
        }
        return $months;
    }
}
