<?php

namespace App\Http\Controllers;

use App\Http\UseCase\User\GetCreateData;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    // public function index(Request $request)
    // {
    // }

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

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param UserResultIndexRequest $request
    //  * @return \Illuminate\Http\RedirectResponse
    //  */
    // public function store(UserResultIndexRequest $request)
    // {
    //     //
    // }

    /*
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    // public function show(int $id)
    // {
    //     //
    // }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
