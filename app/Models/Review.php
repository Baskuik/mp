<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $primaryKey = 'review_id';

    const REVIEW_ID = 'review_id';
    const REVIEWER_ID = 'reviewer_id';
    const REVIEWEE_ID = 'reviewee_id';
    const LISTING_ID = 'listing_id';
    const REVIEWS_ACTIVE = 'reviews_active';
    const REVIEW_RATING = 'rating';
    const REVIEW_COMMENT = 'comment';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $fillable = [
        'reviewer_id',
        'reviewee_id',
        'listing_id',
        'reviews_active',
        'rating',
        'comment',
    ];
}