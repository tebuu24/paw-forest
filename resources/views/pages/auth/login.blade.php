<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Log In') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
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
            <h1>{{ __('Log in') }}</h1>
            <br>
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label>{{ __('Email') }}</label>
                    <input name="email" type="text" required>
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