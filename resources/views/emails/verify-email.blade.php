<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verificeer je email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }

        .content {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .code-box {
            background-color: #f0f0f0;
            border: 2px solid #007bff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }

        .code-box .label {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
            display: block;
        }

        .code-box .code {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }

        .footer {
            border-top: 1px solid #eee;
            padding-top: 20px;
            color: #999;
            font-size: 12px;
            text-align: center;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>DirectDeal</h1>
        </div>

        <div class="content">
            <p>Hallo {{ $userName }},</p>

            <p>Welkom bij DirectDeal! Bedankt voor je registratie. Om je account te activeren, voer je de volgende
                verificatiecode in op onze website.</p>

            <div class="code-box">
                <span class="label">Jouw verificatiecode:</span>
                <div class="code">{{ $code }}</div>
            </div>

            <p>Deze code is 15 minuten geldig. Voer deze code in op stap 3 van je registratieproces.</p>

            <div class="warning">
                <strong>Beveiligingstip:</strong> Deel deze code niet met anderen. DirectDeal medewerkers zullen nooit
                om je verificatiecode vragen.
            </div>

            <p>Heb je deze email niet aangevraagd? Geen probleem, je kunt deze email gewoon negeren.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} DirectDeal. Alle rechten voorbehouden.</p>
            <p>DirectDeal | Marketplace Platform</p>
        </div>
    </div>
</body>

</html>
