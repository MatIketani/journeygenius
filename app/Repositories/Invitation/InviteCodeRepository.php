<?php

namespace App\Repositories\Invitation;

use App\Dto\Invitation\InviteCodeDTO;
use App\Models\Invitation\InviteCode;

/**
 * Class InviteCodeRepository
 *
 * Responsible of managing all database transactions on invite codes.
 */
class InviteCodeRepository
{
    /**
     * Get an invite code instance from database by its code.
     *
     * @param string $inviteCode
     * @return ?InviteCode
     */
    public function getByCode(string $inviteCode): ?InviteCode
    {
        /**
         * @var ?InviteCode $inviteCode
         */
        $inviteCode = InviteCode::query()->firstWhere('code', $inviteCode);

        return $inviteCode;
    }

    /**
     * Create a new InviteCode instance in the database.
     *
     * @param InviteCodeDTO $inviteCodeDto
     * @return InviteCode
     */
    public function create(InviteCodeDTO $inviteCodeDto): InviteCode
    {
        /**
         * @var InviteCode $inviteCode
         */
        $inviteCode = InviteCode::query()->create([
            'user_id' => $inviteCodeDto->userId,
            'code' => $inviteCodeDto->code,
            'credits_reward' => $inviteCodeDto->creditsReward
        ]);

        return $inviteCode;
    }
}
