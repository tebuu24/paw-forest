<?php
//Laravel autentifikācijas sistēma un lietotāja sesija
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Log In') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <select class="lang-select" onchange="location = this.value;">
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
            <form action="#">
                <div class="form-group">
                    <label>{{ __('Username or Email') }}</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>{{ __('Password') }}</label>
                    <input type="password" required>
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