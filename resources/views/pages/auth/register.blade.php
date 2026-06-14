<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Register') }}</title>
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
            <h1>{{ __('Registration') }}</h1>
            <br>
            <form method="POST" action="/register">
            @csrf
                <div class="form-group">
                    <label>{{ __('Full Name') }}</label>
                    <input name="name" type="text" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Username') }}</label>
                    <input name="username" type="text" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Email') }}</label>
                    <input name="email" type="email" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Address') }}</label>
                    <input name="address" type="text" placeholder="Street, City, Postal Code" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input name="password" type="password" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Confirm Password') }}</label>
                    <input name="password_confirmation" type="password" required>
                </div>
                <br>
                <button type="submit" class="btn btn-green register-btn">{{ __('Create Account') }}</button>
            </form>
            <br>
            <p class="auth-switch-text">
                {{ __('Already have an account?') }} <a href="/login">{{ __('Log in here') }}</a>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>