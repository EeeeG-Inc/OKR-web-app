<?php

namespace App\Services\Quarter;

use App\Enums\Quarter;
use App\Models\Objective;
use Illuminate\Database\Eloquent\Collection;

class ControlFieldsService
{
    public function getQuarterLabels(Collection $quarters): array
    {
        return [
            __('models/quarters.full_year'),
            __('models/quarters.quarter.first_quarter') . '(' . $quarters[0]->from . '月〜' . $quarters[0]->to . '月)',
            __('models/quarters.quarter.second_quarter') . '(' . $quarters[1]->from . '月〜' . $quarters[1]->to . '月)',
            __('models/quarters.quarter.third_quarter') . '(' . $quarters[2]->from . '月〜' . $quarters[2]->to . '月)',
            __('models/quarters.quarter.fourth_quarter') . '(' . $quarters[3]->from . '月〜' . $quarters[3]->to . '月)',
        ];
    }

    public function getQuarterChecked(Objective $objective, Collection $quarters): array
    {
        $quarterChecked = [];
        $quarterId = $objective->quarter_id;

        if ($quarterId === Quarter::FULL_YEAR_ID) {
            $quarterChecked[0] = true;
        } else {
            $quarterChecked[0] = false;
        }

        $i = 1;
        foreach ($quarters as $quarter) {
            if ($quarter->id === $quarterId) {
                $quarterChecked[$i] = true;
            } else {
                $quarterChecked[$i] = false;
            }
            $i++;
        }
        return $quarterChecked;
    }
}
