<?php

namespace App\Dto\Invitation;

/**
 * Class InvitationDTO
 *
 * Invitation model DTO (Data Transfer Object).
 */
class InvitationDTO
{
    public int $invitedUserId;

    public int $inviteCodeId;

    /**
     * Constructor method.
     */
    public function __construct(int $invitedUserId, int $inviteCodeId)
    {
        $this->invitedUserId = $invitedUserId;

        $this->inviteCodeId = $inviteCodeId;
    }
}
