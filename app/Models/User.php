<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Als user verbannen wordt, zet is_active op false
        static::saving(function ($user) {
            if ($user->is_banned === true) {
                $user->is_active = false;
            }
        });
    }

    const USER_ID = 'user_id';
    const USER_NAME = 'name';
    const USER_EMAIL = 'email';
    const USER_EMAIL_VERIFIED_AT = 'email_verified_at';
    const USER_PASSWORD = 'password';
    const USER_IS_ADMIN = 'is_admin';
    const USER_IS_ACTIVE = 'is_active';
    const USER_IS_BANNED = 'is_banned';
    const USER_REMEMBER_TOKEN = 'remember_token';
    const USER_CREATED_AT = 'created_at';
    const USER_UPDATED_AT = 'updated_at';
    const USER_USERNAME = 'username';
    const USER_BIO = 'bio';
    const USER_PROFILE_PHOTO_PATH = 'profile_photo_path';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'is_admin',
        'is_active',
        'is_banned',
        'remember_token',
        'created_at',
        'updated_at',
        'username',
        'bio',
        'profile_photo_path',
        'phone_number',
        'phone_verified',
        'phone_verification_code',
        'phone_verification_sent_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'is_banned' => 'boolean',
            'phone_verified' => 'boolean',
            'phone_verification_sent_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : null;
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class, 'user_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'buyer_id');
    }

    /**
     * Soft delete: zet is_active op false in plaats van hard deleten
     */
    public function delete()
    {
        $this->is_active = false;
        return $this->save();
    }

    /**
     * Hard delete als nodig
     */
    public function forceDelete()
    {
        return parent::delete();
    }
}