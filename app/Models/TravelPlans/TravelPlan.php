<?php

namespace App\Models\TravelPlans;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model TravelPlans
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property array $accommodation_coordinates
 * @property int $max_distance
 * @property array $interests
 * @property int $spending
 *
 * @property string|null $result
 *
 * @property-read string $status_for_humans
 * @property-read User $user
 */
class TravelPlan extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status',
        'accommodation_coordinates',
        'max_distance',
        'interests',
        'spending',
        'result'
    ];

    protected $casts = [
        'accommodation_coordinates' => 'array',
        'interests' => 'array',
        'result' => 'string'
    ];

    /**
     * Create an relationship instance between Travel Plan.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
