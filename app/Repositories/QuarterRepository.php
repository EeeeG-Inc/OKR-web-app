<?php

namespace App\Repositories;

use Carbon\CarbonImmutable;
use App\Enums\Quarter as Q;
use App\Models\Quarter;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class QuarterRepository implements QuarterRepositoryInterface
{
    /** @var Quarter */
    private $quarter;

    public function __construct(Quarter $quarter = null)
    {
        $this->quarter = $quarter ?? new Quarter;
    }

    public function find(int $id): ?Quarter
    {
        return $this->quarter->findOrFail($id);
    }

    public function findQuarterFullYear(): Quarter
    {
        return $this->quarter->find(Q::FULL_YEAR_ID);
    }

    public function create(array $input): Quarter
    {
        return $this->quarter->create($input);
    }

    public function update(int $id, array $input): bool
    {
        $model = $this->quarter->findOrFail($id);
        $model->fill($input);
        return $model->save();
    }

    public function getByCompanyId(int $companyId): Collection
    {
        return $this->quarter->where('company_id', $companyId)->orderBy('quarter', 'asc')->get();
    }

    public function findByQuarterAndCompanyId(int $quarter, int $companyId): ?Quarter
    {
        return $this->quarter->where([
            ['company_id', '=', $companyId],
            ['quarter', '=', $quarter],
        ])->first();
    }

    /**
     * 本日が何年度の何期目なのか返却する
     *
     * @param integer $companyId
     * @return array
     */
    public function getYearAndQuarterAtToday(int $companyId): array
    {
        $today = CarbonImmutable::today();
        $quarterId = 0;
        $thisYear = $today->year;

        foreach ($this->getByCompanyId($companyId) as $quarter) {
            // 1Q 開始が何月に設定されているかによって、年度を取得
            if ($quarter->quarter === 1) {
                switch ($quarter->from) {
                    case 1:
                        break;
                    default:
                        if ($today->month < $quarter->from) {
                            $thisYear = $today->year - 1;
                        }
                        break;
                }
            }

            if ($quarter->from < $quarter->to) {
                // 本日が何期目か取得
                if (($quarter->from <= $today->month) && ($today->month <= $quarter->to)) {
                    $quarterId = $quarter->id;
                    break;
                }
            }

            // 年をまたいでいる場合
            if ($quarter->from > $quarter->to) {
                // 本日が何期目か取得
                if (($quarter->from <= $today->month) && ($today->month <= ($quarter->to + 12))) {
                    $quarterId = $quarter->id;
                    break;
                }

                if (($quarter->from <= ($today->month + 12)) && ($today->month <= $quarter->to)) {
                    $quarterId = $quarter->id;
                    break;
                }
            }
        }

        return [
            'year' => $thisYear,
            'quarter_id' => $quarterId,
        ];
    }
}
