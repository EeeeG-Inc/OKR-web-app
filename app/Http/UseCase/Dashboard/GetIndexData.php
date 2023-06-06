<?php

namespace App\Http\UseCase\Dashboard;

use App\Charts\LatestOkrActivity;
use App\Enums\Role;
use App\Models\User;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveRepositoryInterface;
use App\Repositories\Interfaces\ObjectiveScoreHistoryRepositoryInterface;
use App\Repositories\Interfaces\QuarterRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\ObjectiveRepository;
use App\Repositories\ObjectiveScoreHistoryRepository;
use App\Repositories\QuarterRepository;
use App\Services\Dashboard\SearchService;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var SearchService */
    private $searchService;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    /** @var ObjectiveRepositoryInterface */
    private $objectiveRepo;

    /** @var ObjectiveScoreHistoryRepositoryInterface */
    private $objectiveScoreHistoryRepo;

    /** @var QuarterRepositoryInterface */
    private $quarterRepo;

    public function __construct(
        SearchService $searchService,
        CompanyRepositoryInterface $companyRepo = null,
        ObjectiveRepositoryInterface $objectiveRepo = null,
        ObjectiveScoreHistoryRepositoryInterface $objectiveScoreHistoryRepo = null,
        QuarterRepositoryInterface $quarterRepo = null
    ) {
        $this->searchService = $searchService;
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->objectiveRepo = $objectiveRepo ?? new ObjectiveRepository();
        $this->objectiveScoreHistoryRepo = $objectiveScoreHistoryRepo ?? new ObjectiveScoreHistoryRepository();
        $this->quarterRepo = $quarterRepo ?? new QuarterRepository();
    }

    public function __invoke(array $input = []): array
    {
        $user = Auth::user();

        if ($user->role === Role::ADMIN) {
            $companies = $this->companyRepo->get()->toArray();
            return [
                'users' => $this->searchService->getUsersForAdmin($input),
                'companyIdsChecks' => $this->searchService->getCompanyIdsChecksforAdmin($input, $companies),
                'companies' => $companies,
                'chart' => null,
                'objectives' => null,
            ];
        }

        $companies = $this->companyRepo->getByCompanyGroupId($user->company->company_group_id)->toArray();

        // 現在対応中の OKR を取得
        $quarterData = $this->quarterRepo->getYearAndQuarterAtToday($user->company->id);
        $objectives = $this->objectiveRepo->getByUserIdAndYearAndQuarterId($user->id, $quarterData['year'], $quarterData['quarter_id']);

        return [
            'users' => $this->searchService->getUsers($user, $input),
            'companyIdsChecks' => $this->searchService->getCompanyIdsChecks($input, $companies),
            'companies' => $companies,
            'chart' => $this->createChart($user, $quarterData, $objectives) ?? null,
            'objectives' => $objectives,
        ];
    }

    /**
     * チャートオブジェクト返却
     *
     * @param User $user
     * @param array $quarterData
     * @param Collection $objectives
     */
    private function createChart(User $user, array $quarterData, Collection $objectives)
    {
        if ($objectives->isEmpty()) {
            return null;
        }

        [
            'datasets' => $datasets,
            'dates' => $dates,
        ] = $this->getChartData($objectives);

        if (empty($datasets) || empty($dates)) {
            return null;
        }

        $chart = new LatestOkrActivity;

        foreach ($datasets as $objective => $dataset) {
            // チャートにデータを設定
            $chart->dataset($objective, 'line', $dataset);
        }

        // チャートにラベル設定
        $chart->labels($dates);

        return $chart;
    }

    /**
     * チャートに必要なデータ取得
     *
     * @param Collection $objectives
     * @return array
     */
    private function getChartData(Collection $objectives): array
    {
        $allHistories = [];

        foreach ($objectives as $objective) {
            $histories = $this->objectiveScoreHistoryRepo->getByObjectiveId($objective->id);
            $allHistories[] = $histories;
        }

        [
            'dates' => $dates,
            'tmp_all_scores' => $tmpAllScores,
        ] = $this->getDatesLabel($allHistories);

        $allScores = $this->getAllScores($dates, $objectives, $tmpAllScores);

        return [
            'datasets' => $this->getDataSet($allScores),
            'dates' => $dates,
        ];
    }

    /**
     * チャートに必要なラベルデータを取得
     *
     * @param array $allHistories
     * @return array
     */
    private function getDatesLabel(array $allHistories): array
    {
        $dates = [];
        $tmpAllScores = [];

        // ラベル作成
        foreach ($allHistories as $histories) {
            foreach ($histories as $history) {
                $date = $history->created_at->format('m/d');
                $dates[] = $date;
                $tmpAllScores[$date]["{$history->objective->objective}"] = $history->score;
            }
        }

        return [
            'dates' => array_unique($dates),
            'tmp_all_scores' => $this->fixTmpScores($tmpAllScores)
        ];
    }

    /**
     * セットする用のスコアを修正する
     *
     * @param array $tmpAllScores
     * @return array
     */
    private function fixTmpScores(array $tmpAllScores): array
    {
        $prev = null;

        foreach ($tmpAllScores as $date => $current) {
            if (!is_null($prev)) {
                // 古い日付のスコアが存在したのであればセットする
                foreach ($prev as $objective => $score) {
                    $tmpAllScores[$date][$objective] = $current[$objective] ?? $prev[$objective];
                }
            }
            $prev = $current;
        }

        return $tmpAllScores;
    }

    /**
     * スコア配列の状態を初期化する
     *
     * @param array $dates
     * @param Collection $objectives
     * @return array
     */
    private function initAllScores(array $dates, Collection $objectives): array
    {
        $allScores = [];

        // 0 で初期化
        foreach ($dates as $date) {
            foreach ($objectives as $objective) {
                $allScores[$date][$objective->objective] ?? $allScores[$date][$objective->objective] = 0;
            }
        }

        return $allScores;
    }

    /**
     * スコア配列を取得する
     *
     * @param array $dates
     * @param Collection $objectives
     * @param array $tmpAllScores
     * @return array
     */
    private function getAllScores(array $dates, Collection $objectives, array $tmpAllScores): array
    {
        $allScores = $this->initAllScores($dates, $objectives);

        // データを設定する
        foreach ($tmpAllScores as $date => $tmpScores) {
            foreach ($tmpScores as $objective => $score) {
                $allScores[$date][$objective] = $score;
            }
        }

        return $allScores;
    }

    /**
     * チャートに渡すデータセットを取得する
     *
     * @param array $allScores
     * @return array
     */
    private function getDataSet(array $allScores): array
    {
        $datasets = [];

        foreach ($allScores as $date => $scores) {
            foreach ($scores as $objective => $score) {
                $datasets[$objective][] = $score;
            }
        }

        return $datasets;
    }
}
