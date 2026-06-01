<?php

namespace App\Console\Commands;

use App\Models\Listing;
use Illuminate\Console\Command;

class CleanupListings extends Command
{
    protected $signature   = 'listings:cleanup';
    protected $description = 'Soft-delete advertenties na 1 week (regulier) of 1 maand (premium)';

    public function handle(): void
    {
        // Niet premium: na 1 week
        $regularQuery = Listing::where('status', 'active')
            ->where('created_at', '<', now()->subWeek())
            ->whereHas('seller', fn($q) => $q->where('premium', false));

        $regularCount = $regularQuery->count();
        $regularQuery->delete();

        // Premium: na 1 maand
        $premiumQuery = Listing::where('status', 'active')
            ->where('created_at', '<', now()->subMonth())
            ->whereHas('seller', fn($q) => $q->where('premium', true));

        $premiumCount = $premiumQuery->count();
        $premiumQuery->delete();

        $this->info("✔ {$regularCount} reguliere en {$premiumCount} premium advertentie(s) verwijderd.");
    }
}