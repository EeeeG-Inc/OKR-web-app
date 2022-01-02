<?php

namespace App\Http\Controllers;

use App\Models\Quarter;
use App\Http\Requests\QuarterStoreRequest;
use App\Http\Requests\QuarterUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Flash;

class QuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $quarters = Quarter::where('company_id', $companyId)->get();
        $canCreate = false;

        if ($quarters->isEmpty()) {
            $canCreate = true;
        }

        return view('quarter.index', compact('quarters', 'canCreate', 'companyId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $from = $this->createFrom();
        return view('quarter.create', compact('from'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuarterStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(QuarterStoreRequest $request)
    {
        $input = $request->validated();
        $user = Auth::user();

        $i = 1;
        while ($i < 5) {
            Quarter::create([
                'quarter' => $i,
                'from' => $input[$i . 'q_from'],
                'to'   => $input[$i . 'q_to'],
                'company_id' => $user->company_id,
            ]);
            $i++;
        }
        Flash::success(__('common/message.quarter.store'));
        return redirect()->route('quarter.index');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $companyId
     * @return View
     */
    public function edit(int $companyId)
    {
        $firstQuarter = Quarter::where('company_id', $companyId)
            ->where('quarter', 1)
            ->first();
        $secondQuarter = Quarter::where('company_id', $companyId)
            ->where('quarter', 2)
            ->first();
        $thirdQuarter = Quarter::where('company_id', $companyId)
            ->where('quarter', 3)
            ->first();
        $fourthQuarter = Quarter::where('company_id', $companyId)
            ->where('quarter', 4)
            ->first();
        $from = $this->createFrom();
        return view('quarter.update', compact('companyId', 'firstQuarter', 'secondQuarter', 'thirdQuarter', 'fourthQuarter', 'from'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuarterUpdateRequest  $request
     * @param  int  $companyId
     * @return RedirectResponse
     */
    public function update(QuarterUpdateRequest $request, int $companyId)
    {
        $input = $request->validated();

        $i = 1;
        while ($i < 5) {
            Quarter::where('company_id', $companyId)
                ->where('quarter', $i)
                ->first()
                ->update([
                    'from' => $input[$i . 'q_from'],
                    'to'   => $input[$i . 'q_to'],
                ]);
            $i++;
        }
        Flash::success(__('common/message.quarter.update'));
        return redirect()->route('quarter.index');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }

    private function createFrom(): array
    {
        $from = [];
        $i = 1;
        while ($i < 13) {
            $from[$i] = $i;
            $i++;
        }

        return $from;
    }
}
