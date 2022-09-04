<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\UseCase\ApiToken\GetIndexData;
use App\Http\UseCase\ApiToken\StoreData;
use Illuminate\View\View;

class ApiTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View
     */
    public function index(GetIndexData $case): View
    {
        return view('api_token.index', $case());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreData $case)
    {
        if (!$case()) {
            return redirect()->route('api_token.index');
        }
        return redirect()->route('api_token.index');
    }
}
