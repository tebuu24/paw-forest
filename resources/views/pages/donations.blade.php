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

            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 200px; text-align: center; font-weight: bold; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="donation-goal-box">
                <h2 class="goal-title">{{ __("This Month's Goal: Medical Fund") }}</h2>
                <p class="goal-amount">
                    ${{ number_format($currentSum ?? 0, 0, '.', ',') }} {{ __('of') }} ${{ number_format($targetGoal ?? 5000, 0, '.', ',') }}
                </p>
                <div class="progress-bar-bg" style="background: #e2dcd8; border-radius: 10px; height: 20px; width: 100%; overflow: hidden; margin-top: 10px;">
                    <div class="progress-bar-fill" style="background: #2b7a4b; height: 100%; width: {{ $progressPercentage ?? 0 }}%; transition: width 0.5s ease;"></div>
                </div>
            </div>

            <form method="POST" action="{{ route('donations.store') }}">
                @csrf
                
                <div class="form-group">
                    <label>{{ __('Choose or enter a donation amount ($)') }}</label>
                    <div class="donation-presets" style="margin-bottom: 10px; display: flex; gap: 10px;">
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='10'">$10</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='25'">$25</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='50'">$50</button>
                        <button type="button" class="btn btn-blue preset-btn" onclick="document.getElementById('amount').value='100'">$100</button>
                    </div>
                    <input type="number" id="amount" name="amount" placeholder="{{ __('Other amount') }}" min="1" class="block-card amount-input" style="width: 100%; padding: 10px;" required>
                </div>

                <div class="form-group">
                    <label>{{ __('Payment Method') }}</label>
                    <select name="method_of_payment" style="width: 100%; padding: 10px; border: 1px solid #e2dcd8; border-radius: 6px; background-color: white;" required>
                        <option value="Card">{{ __('Credit / Debit Card') }}</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('Message / Note') }}</label>
                    <textarea name="message" placeholder="{{ __('Leave a nice message for the animals...') }}" style="width: 100%; padding: 10px; border: 1px solid #e2dcd8; border-radius: 6px; min-height: 80px; font-family: inherit;"></textarea>
                </div>

                <hr style="border: 0; border-top: 1px solid #e2dcd8; margin: 25px 0;">
                <p style="font-size: 0.9rem; color: #8a7a74; margin-bottom: 15px;"><i>{{ __('Payment Details') }}</i></p>

                <div class="form-group">
                    <label>{{ __('Cardholder Name') }}</label>
                    <input type="text" value="{{ auth()->user()->name }}" style="width: 100%; padding: 10px; background-color: #f5f5f5; color: #777;" readonly disabled>
                </div>

                <div class="form-group">
                    <label>{{ __('Card Number') }}</label>
                    <input type="text" placeholder="**** **** **** ****" style="width: 100%; padding: 10px;">
                </div>

                <div class="form-row-split" style="display: flex; gap: 15px;">
                    <div class="form-group split-field" style="flex: 1;">
                        <label>{{ __('Expiration Date') }}</label>
                        <input type="text" placeholder="MM/YY" style="width: 100%; padding: 10px;">
                    </div>
                    <div class="form-group split-field" style="flex: 1;">
                        <label>{{ __('CVC') }}</label>
                        <input type="text" placeholder="123" style="width: 100%; padding: 10px;">
                    </div>
                </div>

                <div class="form-spacer" style="margin-top: 20px;"></div>
                <button type="submit" class="btn btn-green submit-donation-btn" style="width: 100%; padding: 12px; font-weight: bold; font-size: 1.1rem; border-radius: 6px; cursor: pointer;">
                    {{ __('Confirm Donation') }}
                </button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>