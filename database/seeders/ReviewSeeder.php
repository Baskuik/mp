<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reviews for Jan (reviewee)
        Review::create([
            'reviewer_id' => 3, // Maria
            'reviewee_id' => 2, // Jan
            'listing_id' => 1,
            'rating' => 5,
            'comment' => 'Uitstekende verkoper! Het item was precies zoals beschreven.',
        ]);

        Review::create([
            'reviewer_id' => 5, // Lisa
            'reviewee_id' => 2, // Jan
            'listing_id' => 5,
            'rating' => 5,
            'comment' => 'Zeer professioneel. Snelle verzending!',
        ]);

        // Reviews for Maria (reviewee)
        Review::create([
            'reviewer_id' => 4, // Piet
            'reviewee_id' => 3, // Maria
            'listing_id' => 2,
            'rating' => 4,
            'comment' => 'Mooie stoel. Goed verpakt aangekomen.',
        ]);

        // Reviews for Piet (reviewee)
        Review::create([
            'reviewer_id' => 5, // Lisa
            'reviewee_id' => 4, // Piet
            'listing_id' => 3,
            'rating' => 5,
            'comment' => 'Boeken in topconditie ontvangen. Zeer blij!',
        ]);

        // Reviews for Lisa (reviewee)
        Review::create([
            'reviewer_id' => 2, // Jan
            'reviewee_id' => 5, // Lisa
            'listing_id' => 4,
            'rating' => 5,
            'comment' => 'Prachtige jurk. Authentiek en goed onderhouden.',
        ]);
    }
}
