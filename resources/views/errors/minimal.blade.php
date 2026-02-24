<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', __('Error')) — {{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <style>
            * { box-sizing: border-box; }
            body {
                margin: 0;
                min-height: 100vh;
                font-family: Inter, ui-sans-serif, system-ui, sans-serif;
                background-color: #ffffff;
                color: #212529;
                -webkit-font-smoothing: antialiased;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
                text-align: center;
            }
            .error-logo {
                font-size: 1.5rem;
                font-weight: 700;
                letter-spacing: -0.02em;
                margin-bottom: 2rem;
            }
            .error-logo a { text-decoration: none; }
            .error-logo .red { color: #E53935; }
            .error-logo .dark { color: #212529; }
            .error-code {
                font-size: 4rem;
                font-weight: 700;
                color: #E53935;
                line-height: 1;
                margin-bottom: 0.5rem;
            }
            .error-heading {
                font-size: 1.25rem;
                font-weight: 600;
                color: #212529;
                margin-bottom: 0.5rem;
            }
            .error-detail {
                font-size: 1rem;
                color: #6c757d;
                max-width: 28rem;
                margin: 0 auto 2rem;
                line-height: 1.5;
            }
            .error-actions { display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.625rem 1.25rem;
                font-size: 0.875rem;
                font-weight: 600;
                font-family: inherit;
                border-radius: 0.5rem;
                text-decoration: none;
                cursor: pointer;
                border: none;
                transition: background-color 0.15s;
            }
            .btn-primary {
                background-color: #E53935;
                color: #fff;
            }
            .btn-primary:hover { background-color: #c62828; }
            .btn-secondary {
                background-color: #fff;
                color: #212529;
                border: 1px solid #dee2e6;
            }
            .btn-secondary:hover { background-color: #f8f9fa; }
        </style>
    </head>
    <body>
        <div class="error-logo">
            <a href="{{ url('/') }}">
                <span class="red">Task</span><span class="dark">Flow</span>
            </a>
        </div>

        <div class="error-code">@yield('code', 'Error')</div>
        <h1 class="error-heading">@yield('message')</h1>
        @hasSection('detail')
            <p class="error-detail">@yield('detail')</p>
        @endif

        <div class="error-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Back to dashboard') }}</a>
            @else
                <a href="{{ url('/') }}" class="btn btn-primary">{{ __('Go to home') }}</a>
            @endauth
            <a href="javascript:history.back()" class="btn btn-secondary">{{ __('Go back') }}</a>
        </div>
    </body>
</html>
