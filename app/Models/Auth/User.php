<?php

namespace App\Models\Auth;

use App\Models\Invitation\InviteCode;
use App\Models\MultiLanguage\Locale;
use App\Models\Wallet\Wallet;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property boolean $super_user
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property bool   $google_account
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Locale $locale
 * @property-read Wallet $wallet
 * @property-read InviteCode $inviteCode
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'locale_id',
        'google_account'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that must be cast to Carbon instances.
     *
     * @var string[] $dates
     */
    protected array $dates = [
        'email_verified_at',
        'last_login_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'super_user' => 'boolean',
        'google_account' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class, 'locale_id');
    }

    /**
     * Create the relationship to Wallet.
     *
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    /**
     * Create the relationship to InviteCode.
     *
     * @return HasOne
     */
    public function invite_code(): HasOne
    {
        return $this->hasOne(InviteCode::class, 'user_id');
    }

    /**
     * Return the current logged-in user instance.
     *
     * @return User
     */
    public static function getInstance(): User
    {
        /**
         * @var User $user
         */
        $user = auth()->user();

        return $user;
    }
}
