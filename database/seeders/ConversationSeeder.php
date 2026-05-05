<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Conversation between Jan (seller) and Maria (buyer) about Radio
        $conv1_id = DB::table('conversations')->insertGetId([
            'listing_id' => 1,
            'seller_id' => 2, // Jan de Vries
            'buyer_id' => 3, // Maria Jansen
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('messages')->insert([
            'conversation_id' => $conv1_id,
            'sender_id' => 3, // Maria
            'body' => 'Hallo, is de radio nog beschikbaar?',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('messages')->insert([
            'conversation_id' => $conv1_id,
            'sender_id' => 2, // Jan
            'body' => 'Ja hoor! Het werkt perfect.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Conversation between Maria (seller) and Piet (buyer) about Chair
        $conv2_id = DB::table('conversations')->insertGetId([
            'listing_id' => 2,
            'seller_id' => 3, // Maria Jansen
            'buyer_id' => 4, // Piet Bakker
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('messages')->insert([
            'conversation_id' => $conv2_id,
            'sender_id' => 4, // Piet
            'body' => 'Kun je meer foto\'s sturen van de stoel?',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('messages')->insert([
            'conversation_id' => $conv2_id,
            'sender_id' => 3, // Maria
            'body' => 'Natuurlijk! Ik stuur je meteen wat extra foto\'s toe.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Conversation between Jan (seller) and Lisa (buyer) about Typewriter
        $conv3_id = DB::table('conversations')->insertGetId([
            'listing_id' => 5,
            'seller_id' => 2, // Jan de Vries
            'buyer_id' => 5, // Lisa Hermans
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('messages')->insert([
            'conversation_id' => $conv3_id,
            'sender_id' => 5, // Lisa
            'body' => 'Wat is de herkomst van deze typemachine?',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('messages')->insert([
            'conversation_id' => $conv3_id,
            'sender_id' => 2, // Jan
            'body' => 'Deze komt uit een erfenis. Origineel Zwitsers fabrikaat.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
