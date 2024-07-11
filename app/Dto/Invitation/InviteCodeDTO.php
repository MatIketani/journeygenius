<?php

namespace App\Dto\Invitation;

/**
 * Class InviteCodeDTO
 *
 * Invite code model DTO (Data Transfer Object).
 */
class InviteCodeDTO
{
    public int $userId;

    public string $code;

    public int $creditsReward;

    /**
     * Constructor method.
     */
    public function __construct(
        int $userId,
        string $code,
        int $creditsReward
    )
    {
        $this->userId = $userId;

        $this->code = $code;

        $this->creditsReward = $creditsReward;
    }
}
