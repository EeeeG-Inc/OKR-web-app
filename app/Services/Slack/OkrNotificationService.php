<?php

namespace App\Services\Slack;

use Config;
use App\Enums\Quarter;
use App\Models\Objective;
use App\Models\User;
use App\Services\Slack\BaseNotificationService;

class OkrNotificationService extends BaseNotificationService
{
    public function getTextWhenCreateOKR(User $user, Objective $objective): string
    {
        $quarter = Quarter::getDescription($objective->quarters->quarter);
        $url = $this->getObjectiveUrl($objective->id);

        $text = "{$user->name}さんが{$objective->year}年{$quarter}の目標を設定しました！" . PHP_EOL;
        $text .= "「{$objective->objective}」" . PHP_EOL;
        $text .= "{$url}";

        return $text;
    }

    public function getTextWhenUpdateOKR(User $user, Objective $objective): string
    {
        $quarter = Quarter::getDescription($objective->quarters->quarter);
        $url = $this->getObjectiveUrl($objective->id);

        $text = "{$user->name}さんが{$objective->year}年{$quarter}の目標を更新しました！" . PHP_EOL;
        $text .= "「{$objective->objective}」" . PHP_EOL;
        $text .= "{$url}";

        return $text;
    }

    public function getTextWhenDestroyOKR(User $user, Objective $objective): string
    {
        $quarter = Quarter::getDescription($objective->quarters->quarter);
        $url = $this->getObjectiveUrl($objective->id);

        $text = "{$user->name}さんの{$objective->year}年{$quarter}の目標を削除されました！" . PHP_EOL;
        $text .= "「{$objective->objective}」" . PHP_EOL;
        $text .= "{$url}";

        return $text;
    }

    private function getObjectiveUrl(int $objectiveId): string
    {
        return Config::get('app.url') . "/key_result?objective_id={$objectiveId}";
    }
}
