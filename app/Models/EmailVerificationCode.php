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

    protected $casts = [
        'expires_at'  => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * The user this verification code belongs to.
     * Uses 'user_id' as the foreign key (matching the renamed primary key on User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Scope: only return codes that have not yet expired.
     */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
                     ->where('is_verified', false);
    }
}