<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Listing 1: Jan's vintage radio
        Listing::create([
            'user_id' => 2, // Jan de Vries
            'category_id' => 1, // Elektronika
            'title' => 'Vintage Philips Radio uit 1960',
            'description' => 'Mooie vintage radio in werkende staat. Houten behuizing met originele details.',
            'price' => 35.00,
            'status' => 'active',
            'location' => 'Amsterdam',
        ]);

        // Listing 2: Maria's vintage chair
        Listing::create([
            'user_id' => 3, // Maria Jansen
            'category_id' => 2, // Meubels
            'title' => 'Midcentury Modern Lounge Stoel',
            'description' => 'Design stoel van bekend designer. Zeer comfortabel en in goede staat.',
            'price' => 65.00,
            'status' => 'active',
            'location' => 'Rotterdam',
        ]);

        // Listing 3: Piet's antique books
        Listing::create([
            'user_id' => 4, // Piet Bakker
            'category_id' => 4, // Boeken
            'title' => 'Set van 3 antieke Duitse boeken uit 1920',
            'description' => 'Originele uitgave met mooie illustraties. Zeldzame verzameling.',
            'price' => 40.00,
            'status' => 'active',
            'location' => 'Utrecht',
        ]);

        // Listing 4: Lisa's vintage dress
        Listing::create([
            'user_id' => 5, // Lisa Hermans
            'category_id' => 3, // Kleding
            'title' => 'Originele Chanel-stijl jurk uit 1950s',
            'description' => 'Authentieke vintage jurk in perfect formaat. Zijde met originele patroon.',
            'price' => 75.00,
            'status' => 'active',
            'location' => 'Groningen',
        ]);

        // Listing 5: Jan's typewriter
        Listing::create([
            'user_id' => 2, // Jan de Vries
            'category_id' => 1, // Elektronika
            'title' => 'Hermes 3000 Mechanische Typemachine',
            'description' => 'Zeer zeldzame Zwitserse typemachine. Perfect werkend.',
            'price' => 95.00,
            'status' => 'active',
            'location' => 'Den Haag',
        ]);
    }
}
