<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Listing;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        if ($listing->listing_type !== 'bidding' || $listing->status !== 'active') {
            abort(403);
        }

        if ($listing->user_id === $request->user()->user_id) {
            return back()->withErrors([
                'amount' => 'Je kunt niet bieden op je eigen item.',
            ]);
        }

        $minimumBid = (float) ($listing->price ?? 0);
        $currentHighest = Bid::where('listing_id', $listing->listing_id)->max('amount');

        if ($currentHighest !== null && (float) $currentHighest > $minimumBid) {
            $minimumBid = (float) $currentHighest;
        }

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                function (string $attribute, mixed $value, $fail) use ($minimumBid): void {
                    if ((float) $value <= $minimumBid) {
                        $formatted = number_format($minimumBid, 2, ',', '.');
                        $fail("Het bod moet hoger zijn dan EUR {$formatted}.");
                    }
                },
            ],
        ]);

        Bid::create([
            'listing_id' => $listing->listing_id,
            'buyer_id' => $request->user()->user_id,
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        return back()->with('status', 'Je bod is geplaatst.');
    }
}
