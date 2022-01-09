<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\UseCase\Member\StoreData;
use Illuminate\Http\RedirectResponse;

class MemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MemberStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
     */
    public function store(MemberStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.create');
        }
        return redirect()->route('dashboard.index');
    }
}
