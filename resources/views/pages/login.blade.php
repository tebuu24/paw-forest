<?php
//Laravel autentifikācijas sistēma un lietotāja sesija
use function Livewire\Volt\{state};
?>

<x-layouts.app>
    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <select class="lang-select">
                    <option value="en" selected>🌐 EN</option>
                    <option value="lv">🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container auth-container">
        <div class="block-card auth-card">
            <h2>Log In</h2>
            <br>
            <form action="/dashboard">
                <div class="form-group">
                    <label>Username or Email</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required>
                </div>
                <br>
                <button type="submit" class="btn btn-blue register-btn">Sign In</button>
            </form>
            <br>
            <p class="auth-switch-text">Don't have an account yet? <a href="/register">Register here</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>
</x-layouts.app>