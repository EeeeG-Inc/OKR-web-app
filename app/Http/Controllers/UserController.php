<?php

namespace App\Http\Controllers;

use App\Http\UseCase\User\GetCreateData;
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
}
