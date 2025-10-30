<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'App') }}</title>
    <link rel="stylesheet" href="/css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root{
            --card-bg: rgba(255,255,255,0.85);
            --accent: #1f8ceb;
            --radius: 12px;
        }
        html,body{height:100%;margin:0}
        body{
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            background-color:#0b1020;
            background-image: url("{{ env('APP_BG','') }}");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }
        .site-wrap{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px 20px;
        }
        .card{
            width:100%;
            max-width:980px;
            background:var(--card-bg);
            border-radius:var(--radius);
            box-shadow:0 10px 30px rgba(2,6,23,0.6);
            padding:28px;
        }
        h1{margin:0 0 12px 0;font-size:28px;color:#071026}
        h3{margin:0 0 8px 0;color:#071026}
        p{color:#0b1220}
        .btn{display:inline-block;padding:10px 16px;background:var(--accent);color:#fff;border-radius:8px;text-decoration:none;font-weight:600}
        .question{margin-bottom:18px;padding:14px;border-radius:10px;background:rgba(255,255,255,0.9);}
        textarea{width:100%;min-height:72px;padding:10px;border-radius:8px;border:1px solid rgba(10,10,10,0.08);resize:vertical}
        ul{padding-left:18px;margin:6px 0}
        .submit-wrap{text-align:center;margin-top:18px}
    </style>
    </head>
    <body>
    <div class="site-wrap">
        <div class="card">
            @yield('content')
        </div>
    </div>
    @include('partials.submit-modal')
</body>
</html>
