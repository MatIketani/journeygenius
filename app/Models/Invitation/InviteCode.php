<?php

namespace App\Models\Invitation;

use App\Models\Auth\User;
use App\Models\Wallet\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model InviteCode
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property int $credits_reward
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Wallet $wallet
 */
class InviteCode extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     *
     * @var string[] $fillable
     */
    public $fillable = [
        'user_id',
        'code',
        'credits_reward'
    ];

    /**
     * Return the user that created the invite code wallet.
     *
     * @return BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'user_id', 'user_id');
    }
}
