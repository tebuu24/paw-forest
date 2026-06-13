<?php
//jauno lietotāju reģistrācija un datu saglabāšana db
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Register') }}</title>
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
            <h1>{{ __('Registration') }}</h1>
            <br>
            <form method="POST" action="/register">
            @csrf
                <div class="form-group">
                    <label>Full Name</label>
                    <input name="name" type="text" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input name="username" type="text" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input name="email" type="email" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input name="address" type="text" placeholder="Street, City, Postal Code" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
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