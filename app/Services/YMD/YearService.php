<?php

namespace App\Services\YMD;

use Carbon\Carbon;

class YearService
{
    public function getYearsForCreate(): array
    {
        $prevYear = Carbon::now()->subYear()->format('Y');
        $year = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear()->format('Y');

        return [
            $prevYear => $prevYear,
            $year => $year,
            $nextYear => $nextYear,
        ];
    }

    public function getYearsForEdit(int $year): array
    {
        $date1 = new Carbon($year . '-01-01');
        $date2 = new Carbon($year . '-01-01');

        $prevYear = $date1->subYear()->format('Y');
        $year = $date2->format('Y');
        $nextYear = $date2->addYear()->format('Y');

        return [
            $prevYear => $prevYear,
            $year => $year,
            $nextYear => $nextYear,
        ];
    }
}
