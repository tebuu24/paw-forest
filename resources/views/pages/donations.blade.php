<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate - Paw Forest</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <a href="/">Home</a> <span>|</span>
                <a href="/gallery">Gallery</a> <span>|</span>
                <a href="/donations"><b>Donate</b></a> <span>|</span>
                <a href="/profile">Profile</a> <span>|</span>
                <a href="/login">Log in</a> <span>|</span>
                
                <select class="lang-select">
                    <option value="en" selected>🌐 EN</option>
                    <option value="lv">🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container donation-container">
        <div class="block-card">
            <h1 class="donation-title">Support the Residents of Paw Forest</h1>
            <p class="donation-subtitle">
                Your donation helps us provide food, safe shelter, and medical care for animals waiting for their forever homes.
            </p>

            <div class="donation-goal-box">
                <h2 class="goal-title">This Month's Goal: Medical Fund</h2>
                <p class="goal-amount">$2,500 of $5,000</p>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill"></div>
                </div>
            </div>

            <form action="/" onsubmit="alert('Thank you for your donation!');">
                <div class="form-group">
                    <label>Choose or enter a donation amount ($)</label>
                    <div class="donation-presets">
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='10'">$10</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='25'">$25</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='50'">$50</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='100'">$100</button>
                    </div>
                    <input type="number" id="amount" placeholder="Other amount" min="1" class="block-card amount-input" required>
                </div>
                
                <div class="form-group">
                    <label>Cardholder Name</label>
                    <input type="text" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" placeholder="**** **** **** ****" required>
                </div>

                <div class="form-row-split">
                    <div class="form-group split-field">
                        <label>Expiration Date</label>
                        <input type="text" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group split-field">
                        <label>CVC</label>
                        <input type="text" placeholder="123" required>
                    </div>
                </div>

                <div class="form-spacer"></div>
                <button type="submit" class="btn btn-green submit-donation-btn">Confirm Donation 🐾</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>