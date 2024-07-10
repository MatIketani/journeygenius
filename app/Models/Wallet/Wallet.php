<?php

namespace App\Models\Wallet;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Wallet
 *
 * @property int $id
 * @property int $user_id
 * @property int $credits
 *
 * @property-read User $user
 */
class Wallet extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'credits'
    ];

    /**
     * Create the model relationship between Wallet and User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
