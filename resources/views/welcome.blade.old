<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('welcome.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .box {
            max-width: 600px;
            margin: 100px auto;
            background: #fff;
            padding: 2rem;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        a {
            text-decoration: none;
            color: #4a235a;
            margin: 0 10px;
            font-weight: bold;
        }

        .actions {
            margin-top: 20px;
        }

        .lang {
            margin-top: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="box">
        <h1>{{ __('welcome.title') }}</h1>
        <p>{{ __('welcome.message') }}</p>

        <div class="actions">
            <a href="{{ route('login') }}">
                {{ __('welcome.login') }}
            </a>
        </div>


        <div class="lang">
            {{ __('welcome.language') }}:
            <a href="{{ route('lang.switch', 'en') }}">EN</a> |
            <a href="{{ route('lang.switch', 'es') }}">ES</a>
        </div>
    </div>

</body></html>