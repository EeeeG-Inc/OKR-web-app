<?php
namespace App\Http\UseCase\ApiToken;

use App\Repositories\Interfaces\ApiTokenRepositoryInterface;
use App\Repositories\ApiTokenRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    /** @var ApiTokenRepositoryInterface */
    private $apiTokenRepo;

    public function __construct(ApiTokenRepositoryInterface $apiTokenRepo = null)
    {
        $this->apiTokenRepo = $apiTokenRepo ?? new ApiTokenRepository();
    }

    public function __invoke(): array
    {
        $isNoToken = true;
        $user = Auth::user();
        $apiToken = $this->apiTokenRepo->findByCompanyId($user->company_id);
        $token = '';

        if (!is_null($apiToken)) {
            $isNoToken = false;
            $token = $apiToken->plain_text_token;
        }

        return [
            'token' => $token,
            'isNoToken' => $isNoToken,
        ];
    }
}
