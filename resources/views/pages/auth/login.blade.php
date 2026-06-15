<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Paw Forest - Log In') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('favicon.ico') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <a href="/" style="text-decoration: none; color: inherit;">
                    <h2>🏠 Paw Forest</h2>
                </a>
            </div>
            <nav class="pub-nav">
                <a href="/">{{ __('Home') }}</a> <span>|</span>
                
                <select class="lang-select" onchange="location = this.value;" style="margin-left: 5px;">
                    <option value="/lang/en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🌐 EN</option>
                    <option value="/lang/lv" {{ app()->getLocale() == 'lv' ? 'selected' : '' }}>🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>
    <main class="container auth-container">
        <div class="block-card auth-card">
            
            {{-- NATIVE VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ __($error) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FIXED: ACCOUNT BLOCKED / MANUAL REDIRECT ERRORS --}}
            @if (session('error'))
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-size: 0.9rem;">
                    <span style="font-weight: bold;">⚠️ {{ __(session('error')) }}</span>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-size: 0.9rem;">
                    {{ __(session('status')) }}
                </div>
            @endif
            
            <h1>{{ __('Log in') }}</h1>
            <br>
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label>{{ __('Email') }}</label>
                    <input name="email" type="text" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input name="password" type="password" required>
                </div>
                <br>
                <button type="submit" class="btn btn-blue register-btn">{{ __('Sign In') }}</button>
            </form>
            <br>
            <p class="auth-switch-text">
                {{ __("Don't have an account yet?") }} <a href="/register">{{ __('Register here') }}</a>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>