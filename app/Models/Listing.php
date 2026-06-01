<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use SoftDeletes;
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


    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'status',
        'location',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, User::USER_ID);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class, 'listing_id', 'listing_id');
    }
}