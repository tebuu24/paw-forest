<?php
//jauno lietotāju reģistrācija un datu saglabāšana db
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Forest - Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
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
            <h1>Registration</h1>
            <br>
            <form action="gallery.html">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" placeholder="Street, City, Postal Code" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" required>
                </div>
                <br>
                <button type="submit" class="btn btn-green register-btn">Create Account</button>
            </form>
            <br>
            <p class="auth-switch-text">Already have an account? <a href="/login">Log in here</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>