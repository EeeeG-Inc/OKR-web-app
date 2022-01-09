<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagerStoreRequest;
use App\Http\UseCase\Manager\StoreData;
use Illuminate\Http\RedirectResponse;

class ManagerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param ManagerStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
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
