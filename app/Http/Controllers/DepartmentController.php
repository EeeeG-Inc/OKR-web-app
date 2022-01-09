<?php

namespace App\Http\Controllers;

use App\Http\UseCase\Department\StoreData;
use App\Http\Requests\DepartmentStoreRequest;

class DepartmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DepartmentStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.create');
        }

        return redirect()->route('dashboard.index');
    }
}
