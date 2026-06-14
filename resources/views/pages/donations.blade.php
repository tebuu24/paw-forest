<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Donate - Paw Forest') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <a href="/">{{ __('Home') }}</a> <span>|</span>
                <a href="/gallery">{{ __('Gallery') }}</a> <span>|</span>
                <a href="/donations"><b>{{ __('Donate') }}</b></a> <span>|</span>
                @auth
                    <a href="/profile">{{ __('Profile') }}</a>

                    @if(auth()->user()->isEmployee())
                        <span>|</span><a href="/dashboard">{{ __('Admin Panel') }}</a>
                    @endif

                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">{{ __('Log out') }}</button>
                    </form>
                @else
                    <a href="/login" class="btn-nav-auth">{{ __('Log in') }}</a>
                @endauth
                
                <select class="lang-select" onchange="location = this.value;">
                    <option value="/lang/en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🌐 EN</option>
                    <option value="/lang/lv" {{ app()->getLocale() == 'lv' ? 'selected' : '' }}>🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container donation-container">
        <div class="block-card">
            <h1 class="donation-title">{{ __('Support the Residents of Paw Forest') }}</h1>
            <p class="donation-subtitle">
                {{ __('Your donation helps us provide food, safe shelter, and medical care for animals waiting for their forever homes.') }}
            </p>

            <div class="donation-goal-box">
                <h2 class="goal-title">{{ __("This Month's Goal: Medical Fund") }}</h2>
                <p class="goal-amount">{{ __(':current of :target', ['current' => '$2,500', 'target' => '$5,000']) }}</p>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill"></div>
                </div>
            </div>

            <form action="/" onsubmit="alert('{{ __('Thank you for your donation!') }}');">
                <div class="form-group">
                    <label>{{ __('Choose or enter a donation amount ($)') }}</label>
                    <div class="donation-presets">
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='10'">$10</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='25'">$25</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='50'">$50</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='100'">$100</button>
                    </div>
                    <input type="number" id="amount" placeholder="{{ __('Other amount') }}" min="1" class="block-card amount-input" required>
                </div>
                
                <div class="form-group">
                    <label>{{ __('Cardholder Name') }}</label>
                    <input type="text" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label>{{ __('Card Number') }}</label>
                    <input type="text" placeholder="**** **** **** ****" required>
                </div>

                <div class="form-row-split">
                    <div class="form-group split-field">
                        <label>{{ __('Expiration Date') }}</label>
                        <input type="text" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group split-field">
                        <label>{{ __('CVC') }}</label>
                        <input type="text" placeholder="123" required>
                    </div>
                </div>

                <div class="form-spacer"></div>
                <button type="submit" class="btn btn-green submit-donation-btn">{{ __('Confirm Donation 🐾') }}</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>