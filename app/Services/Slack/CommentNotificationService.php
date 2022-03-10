<?php

namespace App\Services\Slack;

use Config;
use App\Models\Objective;
use App\Models\User;
use App\Services\Slack\BaseNotificationService;

class CommentNotificationService extends BaseNotificationService
{
    public function getTextWhenCommented(User $user, Objective $objective): string
    {
        $url = $this->getKeyResultUrl($objective->id);
        $text = "{$objective->user->name}さんの目標「{$objective->objective}」に{$user->name}さんがコメントしました！" . PHP_EOL;
        $text .= "{$url}";

        return $text;
    }

    public function getTextWhenDeleted(User $user, Objective $objective): string
    {
        $url = $this->getKeyResultUrl($objective->id);
        $text = "{$user->name}さんのコメントが削除されました" . PHP_EOL;
        $text .= "{$url}";

        return $text;
    }

    private function getKeyResultUrl(int $objectiveId): string
    {
        return Config::get('app.url') . "/key_result?objective_id={$objectiveId}";
    }
}
