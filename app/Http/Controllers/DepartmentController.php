<?php

namespace App\Http\Controllers;

use App\Http\UseCase\Department\StoreData;
use App\Http\Requests\DepartmentStoreRequest;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse
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
