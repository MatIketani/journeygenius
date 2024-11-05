<?php

namespace App\Http\Controllers\UsersManagement;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class UsersManagementController extends Controller
{
    /**
     * GET /users/
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = User::all();

        return view('users-management.show', compact('users'));
    }

    /**
     * GET /users/delete/{id}
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $id = decrypt($id);

        User::query()->find($id)->delete();

        return redirect()->back()->with([
            'success' => trans('messages.user_successfully_deleted')
        ]);
    }
}
