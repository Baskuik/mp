<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificatiecode - DirectDeal</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
            color: #18181b;
        }
        .container {
            max-width: 560px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #2D6A4F;
            padding: 32px 40px;
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
        }
        .logo span {
            color: #F4A261;
        }
        .body {
            padding: 40px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 16px 0;
            color: #18181b;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            color: #52525b;
            margin: 0 0 16px 0;
        }
        .code-box {
            background-color: #f4f4f5;
            border: 2px dashed #2D6A4F;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 24px 0;
        }
        .code {
            font-size: 40px;
            font-weight: 700;
            letter-spacing: 12px;
            color: #2D6A4F;
            font-family: 'Courier New', monospace;
        }
        .expiry {
            font-size: 13px;
            color: #71717a;
            margin-top: 8px;
        }
        .footer {
            border-top: 1px solid #e4e4e7;
            padding: 24px 40px;
            text-align: center;
        }
        .footer p {
            font-size: 13px;
            color: #a1a1aa;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Direct<span>Deal</span></div>
        </div>
        <div class="body">
            <h1>Hallo {{ $name }},</h1>
            <p>
                Bedankt voor je registratie bij DirectDeal! Om je account te activeren, voer je onderstaande verificatiecode in op de registratiepagina.
            </p>
            <div class="code-box">
                <div class="code">{{ $code }}</div>
                <div class="expiry">Deze code is 15 minuten geldig</div>
            </div>
            <p>
                Als je geen account hebt aangemaakt bij DirectDeal, kun je deze e-mail negeren.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} DirectDeal. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>
</html>