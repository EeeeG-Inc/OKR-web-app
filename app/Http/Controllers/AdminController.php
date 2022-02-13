<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\UseCase\Admin\UpdateData;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo = null)
    {
        $this->userRepo = $userRepo ?? new UserRepository();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        $admin = Auth::user();
        return view('admin.edit', compact(['admin']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUpdateRequest $request
     * @param UpdateData $case
     * @return RedirectResponse
     */
    public function update(AdminUpdateRequest $request, UpdateData $case): RedirectResponse
    {
        $input = $request->validated();

        if (!$case($input)) {
            return redirect()->route('admin.edit');
        }
        return redirect()->route('dashboard.index');
    }

    /**
     * @param int $userId
     * @return RedirectResponse;
     */
    public function proxyLogin(int $userId)
    {
        if (Auth::user()->role !== Role::ADMIN) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $user = $this->userRepo->find($userId);
        Auth::login($user);
        Flash::success(__('common/message.admin.proxy_login', ['name' => $user->name]));

        return redirect()->route('dashboard.index');
    }
}
