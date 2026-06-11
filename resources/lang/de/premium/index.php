<?php

return [

    // Controller flash messages
    'error_no_payment'      => 'Keine Zahlung gefunden.',
    'error_payment_failed'  => 'Zahlung fehlgeschlagen. Bitte versuche es erneut.',

    // Checkout page
    'checkout' => [
        'title'             => 'Kasse · Premium',
        'back'              => 'Zurück zu Premium',
        'eyebrow'           => 'DirectDeal Premium',
        'heading'           => 'Kasse.',
        'heading_em'        => 'Einmalig.',
        'subtitle'          => 'Sichere Zahlung über Stripe · SSL-verschlüsselt',

        'order_step'        => 'Bestellung',
        'product_name'      => 'Premium-Mitgliedschaft',
        'product_sub'       => 'Lebenslanger Zugang · einmalig',
        'subtotal'          => 'Zwischensumme',
        'vat'               => 'MwSt. (0%)',
        'total'             => 'Gesamt',
        'once_pill'         => 'Einmalig',

        'includes_label'    => 'Inbegriffen',
        'includes'          => [
            'Auto-Bieten',
            'Posteingang-Priorität',
            'Statistiken',
            'Push-Benachrichtigungen',
            'Premium-Rahmen',
            'Max. 10 Anzeigen',
            'Keine Werbung',
            'Premium-Abzeichen',
            '30 Tage Garantie',
        ],

        'guarantee_title'   => 'Einfach kündigen',
        'guarantee_body'    => 'Nicht zufrieden? Kündige deine Mitgliedschaft ganz einfach.',

        'payment_step'      => 'Zahlungsdaten',
        'payment_method'    => 'Zahlungsmethode',
        'email_label'       => 'E-Mail-Adresse',
        'card_name_label'   => 'Name auf der Karte',
        'card_name_placeholder' => 'Max Mustermann',
        'pay_button'        => '€9,99 bezahlen',
        'processing'        => 'Wird verarbeitet...',

        'trust_ssl'         => 'SSL-gesichert',
        'trust_stripe'      => 'Stripe Payments',
        'trust_guarantee'   => '30 Tage Garantie',
    ],

    // Index page
    'index' => [
        'title'             => 'Premium · DirectDeal',
        'eyebrow'           => 'DirectDeal Premium',
        'heading'           => 'Mehr aus DirectDeal herausholen?',
        'heading_em'        => 'Jetzt upgraden.',
        'sub'               => 'Eine einmalige Zahlung von €9,99. Kein Abo, keine versteckten Kosten. Lebenslanger Zugang zu Auto-Bieten, Posteingang-Priorität, Statistiken und neun weiteren Vorteilen.',

        'btn_upgrade'       => 'Für €9,99 upgraden',
        'btn_purchased'     => '✓ Gekauft',
        'btn_features'      => 'Vorteile ansehen',

        'social_count'      => '+ Nutzer',
        'social_sub'        => 'sind dir bereits voraus',

        'price_period'      => 'Einmalig',
        'price_label'       => 'Für immer · keine Verlängerungen',
        'price_more'        => '+4 weitere Vorteile',

        'hero_card_items'   => [
            'Auto-Bieten auf Anzeigen',
            'Priorität im Posteingang',
            'Anzeigenstatistiken',
            'Push-Benachrichtigungen',
            'Keine Werbung',
        ],

        'features_label'    => 'Inbegriffen',
        'features_heading'  => 'Alles, was du',
        'features_heading_em' => 'bekommst',
        'features_desc'     => 'Ein Upgrade, neun Vorteile freigeschaltet. Hier ist genau, was du bekommst.',

        'limit_label'       => 'Anzeigenlimit',
        'limit_heading'     => 'Doppelt so viel',
        'limit_heading_em'  => 'Platz',
        'limit_desc'        => 'Premium-Nutzer dürfen 10 aktive Anzeigen schalten – kostenlose Nutzer nur 5.',
        'limit_free'        => 'Kostenlos',
        'limit_premium'     => 'Premium',
        'limit_ads'         => 'Anzeigen',

        'compare_label'     => 'Vergleich',
        'compare_heading'   => 'Kostenlos',
        'compare_heading_em' => 'vs',
        'compare_heading_suffix' => 'Premium',
        'compare_col_free'  => 'Kostenlos',
        'compare_col_prem'  => 'Premium',
        'compare_recommended' => 'Empfohlen',
        'compare_col_feature' => 'Funktion',
        'compare_rows'      => [
            ['Anzeigen schalten', true, true],
            ['Nachrichten senden', true, true],
            ['Max. 5 Anzeigen', true, false],
            ['Max. 10 Anzeigen', false, true],
            ['Auto-Bieten', false, true],
            ['Priorität im Posteingang', false, true],
            ['Anzeigenstatistiken', false, true],
            ['Push-Benachrichtigungen', false, true],
            ['Hervorgehobener Anzeigenrahmen', false, true],
            ['Erweiterte Posteingang-Filter', false, true],
            ['Premium-Abzeichen im Profil', false, true],
            ['Keine Werbung / Pop-ups', false, true],
        ],

        'cta_eyebrow'       => 'Bereit loszulegen?',
        'cta_heading'       => 'Heute upgraden.',
        'cta_heading_em'    => 'Kein Abo.',
        'cta_sub'           => 'Einmalige Zahlung von €9,99. Nie wieder über Limits oder verpasste Chancen nachdenken.',
        'cta_btn'           => 'Jetzt für €9,99 starten',
        'cta_purchased'     => '✓ Du hast bereits Premium',

        'trust_ssl'         => '🔒 SSL-gesichert',
        'trust_stripe'      => '💳 Stripe Payments',
        'trust_guarantee'   => '↩ 30 Tage Garantie',

        'sticky_btn'        => 'Für €9,99 upgraden →',

        'features_list'     => [
            [
                'img'   => 'auto-bieden.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Auto-Bieten',
                'desc'  => 'Lege ein Höchstgebot fest und lass das System automatisch bieten. Verpasse nie mehr eine Chance, wenn du nicht da bist.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'inbox-prioriteit.jpg',
                'bg'    => '#FEF1E6',
                'title' => 'Posteingang-Priorität',
                'desc'  => 'Deine Nachrichten werden ganz oben im Posteingang der Verkäufer platziert, sodass du schneller Antworten erhältst.',
                'accent'=> '#E07B2A',
            ],
            [
                'img'   => 'statistieken.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Anzeigenstatistiken',
                'desc'  => 'Sieh pro Anzeige, wie viele Personen sie geöffnet oder gespeichert haben. Optimiere deine Listings datenbasiert.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'push-notificaties.jpg',
                'bg'    => '#FEF1E6',
                'title' => 'Push-Benachrichtigungen',
                'desc'  => 'Wähle Kategorien, Unterkategorien oder bestimmte Artikel. Erhalte sofort eine Benachrichtigung bei neuen Einstellungen.',
                'accent'=> '#E07B2A',
            ],
            [
                'img'   => 'uitlichtende-border.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Hervorgehobener Rahmen',
                'desc'  => 'Ein goldener Rahmen um deine Anzeigen zeigt Käufern sofort, dass du ein Premium-Verkäufer bist.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'geen-advertenties.jpg',
                'bg'    => '#EEF0FE',
                'title' => 'Keine Werbung',
                'desc'  => 'Keine Banner, keine Pop-ups. Durchsuche DirectDeal sauber, schnell und ohne Ablenkung.',
                'accent'=> '#4F6AE0',
            ],
            [
                'img'   => '10-advertenties.jpg',
                'bg'    => '#FEF1E6',
                'title' => '10 Anzeigen',
                'desc'  => 'Kostenlose Nutzer dürfen 5 Anzeigen schalten. Du hast Platz für 10 aktive Listings gleichzeitig.',
                'accent'=> '#E07B2A',
            ],
            [
                'img'   => 'premium-badge.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Premium-Abzeichen',
                'desc'  => 'Ein sichtbares Abzeichen auf deinem Profil zeigt Käufern, dass du ein seriöser und aktiver Verkäufer bist.',
                'accent'=> '#2E7A4F',
            ],
            [
                'img'   => 'geavanceerde-filters.jpg',
                'bg'    => '#E8F3EC',
                'title' => 'Erweiterte Filter',
                'desc'  => 'Filtere den Posteingang nach Premium/Nicht-Premium, Datum, Uhrzeit und mehr. Finde genau das, was du suchst.',
                'accent'=> '#2E7A4F',
            ],
        ],
    ],

    // Success page
    'success' => [
        'title'   => 'Zahlung erfolgreich · DirectDeal',
        'icon'    => '👑',
        'heading' => 'Willkommen bei Premium!',
        'sub'     => 'Deine Zahlung war erfolgreich. Dein Konto wurde sofort aktualisiert — genieße alle Premium-Vorteile.',
        'btn'     => 'Zur Startseite →',
    ],

];