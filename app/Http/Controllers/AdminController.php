<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Flash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function proxyLogin(int $userId)
    {
        if (Auth::user()->role !== Role::ADMIN) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $user = User::find($userId);
        Auth::login($user);
        Flash::success(__('common/message.admin.proxy_login', ['name' => $user->name]));

        return redirect()->route('dashboard.index');
    }
}
