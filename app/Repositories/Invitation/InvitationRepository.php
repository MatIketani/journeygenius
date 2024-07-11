<?php

namespace App\Repositories\Invitation;

use App\Dto\Invitation\InvitationDTO;
use App\Models\Invitation\Invitation;

/**
 * Class InvitationRepository
 *
 * Responsible of managing all database transactions on invitations.
 */
class InvitationRepository
{
    /**
     * Create a new invitation instance in the database.
     *
     * @param InvitationDTO $invitationDto
     * @return Invitation
     */
    public function create(InvitationDTO $invitationDto): Invitation
    {
        /**
         * @var Invitation $invitation
         */
        $invitation = Invitation::query()->create([
            'invited_user_id' => $invitationDto->invitedUserId,
            'invite_code_id' => $invitationDto->inviteCodeId
        ]);

        return $invitation;
    }
}
