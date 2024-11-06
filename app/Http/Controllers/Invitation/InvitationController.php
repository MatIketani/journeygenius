<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterByInvitationValidator;
use App\Repositories\Invitation\InviteCodeRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class InvitationController
 *
 * Controller responsible for the invitation management.
 */
class InvitationController extends Controller
{
    /**
     * InviteCodeRepository instance.
     *
     * @var InviteCodeRepository $inviteCodeRepository
     */
    private InviteCodeRepository $inviteCodeRepository;

    /**
     * InvitationController constructor.
     *
     * @param InviteCodeRepository $inviteCodeRepository InviteCodeRepository dependency injection.
     */
    public function __construct(InviteCodeRepository $inviteCodeRepository)
    {
        $this->inviteCodeRepository = $inviteCodeRepository;
    }

    /**
     * GET /invitation/register/{inviteCode}
     *
     * @param string $inviteCode
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function registerByInvitation(string $inviteCode)
    {
        $inviteCode = decrypt($inviteCode);

        $inviteCode = $this->inviteCodeRepository->getByCode($inviteCode);

        if (!$inviteCode) {

            return redirect()->route('home')->with([
                'error' => trans('messages.invalid_invitation_code'),
            ]);
        }

        return view('auth.register', ['inviteCode' => $inviteCode->code]);
    }
}
