<?php

namespace App\Models\Invitation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields.
     *
     * @var string[] $fillable
     */
    public $fillable = [
        'invited_user_id',
        'invite_code_id'
    ];
}
