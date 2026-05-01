<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'code',
        'is_verified',
        'expires_at',
    ];

        protected $hidden = [
            'code',
        ];
}
