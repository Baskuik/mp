<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD

class Listing extends Model
{
    protected $primaryKey = 'listing_id';

    const LISTING_ID = 'listing_id';
    const USER_ID = 'user_id';
    const CATEGORY_ID = 'category_id';
    const LISTING_TITLE = 'title';
    const LISTING_DESCRIPTION = 'description';
    const LISTING_PRICE = 'price';
    const LISTING_STATUS = 'status';
    const LISTING_LOCATION = 'location';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

=======
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Listing extends Model
{
    use HasFactory;
>>>>>>> mainpage

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'status',
        'location',
<<<<<<< HEAD
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, User::USER_ID);
    }
}
=======
        'label',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ListingImage::class)->where('is_primary', true);
    }
}
>>>>>>> mainpage
