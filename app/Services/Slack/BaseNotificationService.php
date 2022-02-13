<?php

namespace App\Services\Slack;

use App\Models\User;
use App\Models\Slack;
use App\Repositories\Interfaces\SlackRepositoryInterface;
use App\Repositories\SlackRepository;
use GuzzleHttp\Client;

abstract class BaseNotificationService
{
    /** @var SlackRepositoryInterface */
    private $slackRepo;

    public function __construct(SlackRepositoryInterface $slackRepo = null)
    {
        $this->slackRepo = $slackRepo ?? new SlackRepository();
    }

    public function send(User $user, string $text): bool
    {
        $slack = $this->slackRepo->findByCompanyId($user->company_id);

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
        $webhook = $slack->webhook ?? null;

        if (is_null($webhook)) {
            return false;
        }

        if (!$slack->is_active) {
            return false;
        }

        return true;
    }
}
