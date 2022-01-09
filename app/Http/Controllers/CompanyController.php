<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\UseCase\Company\StoreData;
use \Illuminate\Http\RedirectResponse;

class CompanyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CompanyStoreRequest $request, StoreData $case)
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('user.create');
        }

        return redirect()->route('dashboard.index');
    }
}
