<?php
namespace App\Http\UseCase\ApiToken;

use App\Repositories\Interfaces\ApiTokenRepositoryInterface;
use App\Repositories\ApiTokenRepository;
use Flash;
use Illuminate\Support\Facades\Auth;

class StoreData
{
    /** @var ApiTokenRepositoryInterface */
    private $apiTokenRepo;

    public function __construct(ApiTokenRepositoryInterface $apiTokenRepo = null)
    {
        $this->apiTokenRepo = $apiTokenRepo ?? new ApiTokenRepository();
    }

    public function __invoke(): bool
    {
        $user = Auth::user();
        $personalAccessToken = $user->createToken('api-token-user_id-' . $user->id)->accessToken;
        $apiToken = $this->apiTokenRepo->findByCompanyId($user->company_id);
        $input = [
            'personal_access_token_id' => $personalAccessToken->id,
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ];

        if (is_null($apiToken)) {
            $this->apiTokenRepo->create($input);
        } else {
            $this->apiTokenRepo->update($apiToken->id, $input);
        }

        Flash::success(__('common/message.api_token.store'));
        return true;
    }
}
