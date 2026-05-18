<?php

namespace Database\Seeders;

use App\Models\Bid;
use Illuminate\Database\Seeder;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bids on Listing 1 (Radio)
        Bid::create([
            'listing_id' => 1,
            'buyer_id' => 3, // Maria
            'amount' => 30.00,
        ]);

        Bid::create([
            'listing_id' => 1,
            'buyer_id' => 5, // Lisa
            'amount' => 35.00,
        ]);

        // Bids on Listing 2 (Chair)
        Bid::create([
            'listing_id' => 2,
            'buyer_id' => 2, // Jan
            'amount' => 60.00,
        ]);

        Bid::create([
            'listing_id' => 2,
            'buyer_id' => 4, // Piet
            'amount' => 65.00,
        ]);

        // Bids on Listing 4 (Dress)
        Bid::create([
            'listing_id' => 4,
            'buyer_id' => 2, // Jan
            'amount' => 70.00,
        ]);

        Bid::create([
            'listing_id' => 4,
            'buyer_id' => 3, // Maria
            'amount' => 75.00,
        ]);

        // Bids on Listing 5 (Typewriter)
        Bid::create([
            'listing_id' => 5,
            'buyer_id' => 4, // Piet
            'amount' => 90.00,
        ]);

        Bid::create([
            'listing_id' => 5,
            'buyer_id' => 3, // Maria
            'amount' => 95.00,
        ]);
    }
}
