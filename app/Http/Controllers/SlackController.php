<?php

namespace App\Http\Controllers;

use App\Http\UseCase\Slack\GetIndexData;
use App\Http\UseCase\Slack\GetEditData;
use App\Http\UseCase\Slack\StoreData;
use App\Http\UseCase\Slack\UpdateData;
use App\Http\UseCase\Slack\ChangeIsActive;
use App\Http\Requests\SlackStoreRequest;
use App\Http\Requests\SlackUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SlackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param GetIndexData $case
     * @return View
     */
    public function index(GetIndexData $case): View
    {
        return view('slack.index', $case());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('slack.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SlackStoreRequest $request
     * @param StoreData $case
     * @return RedirectResponse;
     */
    public function store(SlackStoreRequest $request, StoreData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('slack.create');
        }
        return redirect()->route('slack.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $companyId
     * @param GetEditData $case
     * @return View
     */
    public function edit(int $companyId, GetEditData $case): View
    {
        return view('slack.edit', $case($companyId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SlackUpdateRequest  $request
     * @param  int  $companyId
     * @param  UpdateData $case
     * @return RedirectResponse
     */
    public function update(SlackUpdateRequest $request, $companyId, UpdateData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input, $companyId)) {
            return redirect()->route('slack.edit', $companyId);
        }
        return redirect()->route('slack.index');
    }

    /**
     * 通知停止
     *
     * @param ChangeIsActive $case
     * @return RedirectResponse
     */
    public function stop(ChangeIsActive $case): RedirectResponse
    {
        $case(false);
        return redirect()->route('slack.index');
    }

    /**
     * 通知再開
     *
     * @param ChangeIsActive $case
     * @return RedirectResponse
     */
    public function restart(ChangeIsActive $case): RedirectResponse
    {
        $case(true);
        return redirect()->route('slack.index');
    }
}
