<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    protected $primaryKey = 'bid_id';

    const BID_ID = 'bid_id';
    const LISTING_ID = 'listing_id';
    const BUYER_ID = 'buyer_id';
    const AMOUNT = 'amount';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $fillable = [
        'listing_id',
        'buyer_id',
        'amount',
        'status',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}