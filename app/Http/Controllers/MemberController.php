<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\UseCase\Member\StoreData;
use App\Models\User;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param MemberStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
