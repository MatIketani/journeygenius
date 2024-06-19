<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ConfirmSettingsChangesValidator;
use App\Models\Auth\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    /**
     * GET /settings/
     * Main page of settings page.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $currentUser = auth()->user();

        return view('settings.index')->with([
            'user' => $currentUser
        ]);
    }

    /**
     * POST /settings/confirm-changes
     * Confirm settings changes.
     *
     * @throws ValidationException
     */
    public function confirmChanges(ConfirmSettingsChangesValidator $request)
    {
        $requestData = $request->validated();

        /**
         * @var User $currentUser
         */
        $currentUser = auth()->user();

        if (!Hash::check($requestData['password'], $currentUser->password)) {

            throw ValidationException::withMessages([
                'password' => trans('validation.incorrect_password')
            ]);
        }

        $currentUser->update([
            'name' => $request->get('name'),
            'password' => Hash::make($requestData['new_password'])
        ]);

        return redirect('home');
    }
}
