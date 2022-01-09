<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagerStoreRequest;
use App\Http\UseCase\Manager\StoreData;

class ManagerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param ManagerStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ManagerStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.create');
        }

        return redirect()->route('dashboard.index');
    }
}
