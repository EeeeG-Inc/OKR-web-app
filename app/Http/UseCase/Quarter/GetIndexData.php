<?php
namespace App\Http\UseCase\Quarter;

use App\Models\Quarter;
use Illuminate\Support\Facades\Auth;

class GetIndexData
{
    public function __construct()
    {
    }

    public function __invoke(): array
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $quarters = Quarter::where('company_id', $companyId)->get();
        $canCreate = false;

        if ($quarters->isEmpty()) {
            $canCreate = true;
        }

        return [
            'quarters' => $quarters,
            'canCreate' => $canCreate,
            'companyId' => $companyId,
        ];
    }
}
