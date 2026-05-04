<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{


    const REVIEW_ID = 'review_id';
    const REVIEWER_ID = 'reviewer_id';
    const REVIEWEE_ID = 'reviewee_id';
    const LISTING_ID = 'listing_id';
    const REVIEW_RATING = 'rating';
    const REVIEW_COMMENT = 'comment';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';    
    

    protected $fillable = [
        'review_id',
        'reviewer_id',
        'reviewee_id',
        'listing_id',
        'rating',
        'comment',
        'created_at',
        'updated_at',
    ];
}