<?php

namespace App\Http\Controllers;

use App\Http\UseCase\User\GetCreateData;
use App\Http\UseCase\User\GetEditData;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param GetCreateData $case
     * @return View
     */
    public function create(GetCreateData $case)
    {
        return view('user.create', $case());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $userId
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $userId, GetEditData $case): View
    {
        return view('user.edit', $case());
    }
}
