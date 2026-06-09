<?php

return [

    // Controller flash messages
    'error_no_payment'      => 'Geen betaling gevonden.',
    'error_payment_failed'  => 'Betaling niet geslaagd. Probeer het opnieuw.',

    // Checkout page
    'checkout' => [
        'title'             => 'Afrekenen · Premium',
        'back'              => 'Terug naar Premium',
        'eyebrow'           => 'DirectDeal Premium',
        'heading'           => 'Afrekenen.',
        'heading_em'        => 'Eenmalig.',
        'subtitle'          => 'Veilige betaling via Stripe · SSL versleuteld',

        'order_step'        => 'Bestelling',
        'product_name'      => 'Premium Lidmaatschap',
        'product_sub'       => 'Levenslange toegang · eenmalig',
        'subtotal'          => 'Subtotaal',
        'vat'               => 'BTW (0%)',
        'total'             => 'Totaal',
        'once_pill'         => 'Eenmalig',

        'includes_label'    => 'Inbegrepen',
        'includes'          => [
            'Auto-bieden',
            'Inbox prioriteit',
            'Statistieken',
            'Push notificaties',
            'Premium border',
            'Max. 10 advertenties',
            'Geen advertenties',
            'Premium badge',
            '30 dagen garantie',
        ],

        'guarantee_title'   => 'Zeg gemakkelijk op',
        'guarantee_body'    => 'Niet tevreden? Zeg gemakkelijk je lidmaatschap op.',

        'payment_step'      => 'Betaalgegevens',
        'payment_method'    => 'Betaalmethode',
        'email_label'       => 'E-mailadres',
        'card_name_label'   => 'Naam op kaart',
        'card_name_placeholder' => 'Jan Jansen',
        'pay_button'        => 'Betaal €9,99',
        'processing'        => 'Verwerken...',

        'trust_ssl'         => 'SSL Beveiligd',
        'trust_stripe'      => 'Stripe Payments',
        'trust_guarantee'   => '30 dagen garantie',
    ],

    // Index page
    'index' => [
        'title'             => 'Premium · DirectDeal',
        'eyebrow'           => 'DirectDeal Premium',
        'heading'           => 'Meer uit DirectDeal',
        'heading_em'        => 'Upgrade nu.',
        'sub'               => 'Één eenmalige betaling van €9,99. Geen abonnement, geen verborgen kosten. Levenslange toegang tot auto-bieden, inbox-prioriteit, statistieken en negen andere voordelen.',

        'btn_upgrade'       => 'Upgrade voor €9,99',
        'btn_purchased'     => '✓ Gekocht',
        'btn_features'      => 'Bekijk voordelen',

        'social_count'      => '+ gebruikers',
        'social_sub'        => 'gingen je al voor',

        'price_period'      => 'Eenmalig',
        'price_label'       => 'Voor altijd · geen verlengingen',
        'price_more'        => '+4 meer voordelen',

        'hero_card_items'   => [
            'Auto-bieden op advertenties',
            'Prioriteit in de inbox',
            'Advertentiestatistieken',
            'Push notificaties',
            'Geen advertenties',
        ],

        'features_label'    => 'Inbegrepen',
        'features_heading'  => 'Alles wat je',
        'features_heading_em' => 'krijgt',
        'features_desc'     => 'Eén upgrade, negen voordelen ontgrendeld. Hier is exact wat je krijgt.',

        'limit_label'       => 'Advertentielimiet',
        'limit_heading'     => 'Twee keer zoveel',
        'limit_heading_em'  => 'ruimte',
        'limit_desc'        => 'Premium gebruikers mogen 10 actieve advertenties plaatsen - gratis gebruikers slechts 5.',
        'limit_free'        => 'Gratis',
        'limit_premium'     => 'Premium',
        'limit_ads'         => 'advertenties',

        'compare_label'     => 'Vergelijking',
        'compare_heading'   => 'Gratis',
        'compare_heading_em' => 'vs',
        'compare_heading_suffix' => 'Premium',
        'compare_col_free'  => 'Gratis',
        'compare_col_prem'  => 'Premium',
        'compare_recommended' => 'Aanbevolen',
        'compare_col_feature' => 'Functie',
        'compare_rows'      => [
            ['Advertenties plaatsen', true, true],
            ['Berichten sturen', true, true],
            ['Max. 5 advertenties', true, false],
            ['Max. 10 advertenties', false, true],
            ['Auto-bieden', false, true],
            ['Prioriteit in de inbox', false, true],
            ['Advertentiestatistieken', false, true],
            ['Push notificaties', false, true],
            ['Uitlichtende advertentieborder', false, true],
            ['Geavanceerde inbox-filters', false, true],
            ['Premium badge op profiel', false, true],
            ['Geen advertenties / pop-ups', false, true],
        ],

        'cta_eyebrow'       => 'Klaar om te starten?',
        'cta_heading'       => 'Upgrade vandaag.',
        'cta_heading_em'    => 'Geen abonnement.',
        'cta_sub'           => 'Eenmalige betaling van €9,99. Nooit meer nadenken over limieten of gemiste kansen.',
        'cta_btn'           => 'Start nu voor €9,99',
        'cta_purchased'     => '✓ Je hebt al Premium',

        'trust_ssl'         => '🔒 SSL beveiligd',
        'trust_stripe'      => '💳 Stripe Payments',
        'trust_guarantee'   => '↩ 30 dagen garantie',

        'sticky_btn'        => 'Upgrade voor €9,99 →',

        'features_list'     => [
            [
                'img'   => 'auto-bieden.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Auto-bieden',
                'desc'  => 'Stel een maximumbod in en laat het systeem automatisch bieden. Nooit meer een kans missen terwijl je er niet bent.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'inbox-prioriteit.jpg',
                'bg'    => '#FEF1E6',
                'title' => 'Prioriteit in de inbox',
                'desc'  => 'Jouw berichten worden bovenaan de inbox van verkopers geplaatst, zodat je sneller reactie krijgt.',
                'accent'=> '#E07B2A',
            ],
            [
                'img'   => 'statistieken.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Advertentiestatistieken',
                'desc'  => 'Zie per advertentie hoeveel mensen hem openden of opsloegen. Optimaliseer jouw listings op basis van data.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'push-notificaties.jpg',
                'bg'    => '#FEF1E6',
                'title' => 'Push notificaties',
                'desc'  => 'Kies categorieën, subcategorieën of specifieke items. Ontvang direct een melding bij nieuwe plaatsingen.',
                'accent'=> '#E07B2A',
            ],
            [
                'img'   => 'uitlichtende-border.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Uitlichtende border',
                'desc'  => 'Een gouden rand om jouw advertenties zodat kopers direct zien dat jij een premium verkoper bent.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'geen-advertenties.jpg',
                'bg'    => '#EEF0FE',
                'title' => 'Geen advertenties',
                'desc'  => 'Geen banners, geen pop-ups. Browse DirectDeal schoon, snel en afleidingsvrij.',
                'accent'=> '#4F6AE0',
            ],
            [
                'img'   => '10-advertenties.jpg',
                'bg'    => '#FEF1E6',
                'title' => '10 advertenties',
                'desc'  => 'Gratis gebruikers mogen 5 advertenties plaatsen. Jij hebt ruimte voor 10 actieve listings tegelijk.',
                'accent'=> '#E07B2A',
            ],
            [
                'img'   => 'premium-badge.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Premium badge',
                'desc'  => 'Een zichtbare badge op jouw profiel toont kopers dat je een serieuze en actieve verkoper bent.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'geavanceerde-filters.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Geavanceerde filters',
                'desc'  => 'Filter de inbox op premium/non-premium, datum, tijd en meer. Vind precies wat je zoekt.',
                'accent'=> '#2E7A4F',
            ],
        ],
    ],

    // Success page
    'success' => [
        'title'   => 'Betaling geslaagd · DirectDeal',
        'icon'    => '👑',
        'heading' => 'Welkom bij Premium!',
        'sub'     => 'Je betaling is geslaagd. Je account is direct geüpgraded — geniet van alle Premium voordelen.',
        'btn'     => 'Ga naar home →',
    ],

];