<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardSearchRequest;
use App\Http\UseCase\Dashboard\GetIndexData;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View
     */
    public function index(GetIndexData $case)
    {
        return view('dashboard.index', $case());
    }

    /**
     * Search listing of the resource.
     *
     * @param DashboardSearchRequest $request
     * @param GetIndexData $case
     * @return View
     */
    public function search(DashboardSearchRequest $request, GetIndexData $case)
    {
        $input = $request->validated();
        return view('dashboard.index', $case($input));
    }
}
