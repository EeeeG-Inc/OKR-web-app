<?php

namespace App\Services\Slack;

use App\Models\User;
use App\Models\Slack;
use GuzzleHttp\Client;

abstract class BaseNotificationService
{
    public function send(User $user, string $text): bool
    {
        $slack = Slack::where('company_id', $user->company_id)->first();

        if (!$this->canSend($slack)) {
            return false;
        }

        $client = new Client();
        $client->request('POST', $slack->webhook, [
            'json' => [
                "text" => $text,
            ]
        ]);

        return true;
    }

    private function canSend(?Slack $slack): bool
    {
        /** @var ?string */
        $webhook = $slack->webhook;

        if (is_null($webhook)) {
            return false;
        }

        if (!$slack->is_active) {
            return false;
        }

        return true;
    }
}
