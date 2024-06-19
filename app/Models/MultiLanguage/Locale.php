<?php

namespace App\Models\MultiLanguage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Locale
 *
 * @property int $id
 *
 * @property string $code
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Locale extends Model
{
    use HasFactory;

    /**
     * List of mass-assignable fields.
     *
     * @var string[]
     */
    public $fillable = [
        'code'
    ];

    /**
     * Return a list of locale and ids.
     *
     * @return array
     */
    public static function getLocaleList(): array
    {
        return self::query()->pluck('code', 'id')->toArray();
    }
}
