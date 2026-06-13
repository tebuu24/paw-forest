<?php
use function Livewire\Volt\{state};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Profile') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                <a href="/donations">{{ __('Donate') }}</a> <span>|</span>
                @auth
                    <a href="/profile">Profile</a>

                    @if(auth()->user()->isEmployee())
                        <a href="/dashboard">Admin Panel</a>
                    @endif

                    <form method="POST" action="/logout">
                        @csrf
                        <button>Logout</button>
                    </form>
                @else
                    <a href="/login">Log in</a>
                @endauth
                
                <select class="lang-select" onchange="location = this.value;">
                    <option value="/lang/en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🌐 EN</option>
                    <option value="/lang/lv" {{ app()->getLocale() == 'lv' ? 'selected' : '' }}>🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container profile-layout">
        
        <div class="profile-left-column">
            
            <div class="block-card profile-info-card">
                <h1>{{ __('User Profile') }}</h1>
                <br>
                <form action="#">
                    <div class="form-group">
                        <label>{{ __('Name') }}</label>
                        <input type="text" value="Alice Smith">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Username') }}</label>
                        <input type="text" value="alice_smith">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="email" value="alice.smith@example.com">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Address') }}</label>
                        <input type="text" value="Meowtown street 5a, Meowville">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-blue profile-update-btn">{{ __('Update Information') }}</button>
                </form>
            </div>

            <div class="block-card profile-security-card">
                <h2>{{ __('Security Settings') }}</h2>
                <br>
                <form action="#" class="security-form">
                    <h3>{{ __('Change Password') }}</h3>
                    <div class="form-group">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-blue">{{ __('Change Password') }}</button>
                    </div>
                </form>
                
                <hr class="security-divider">

                <form action="#" class="security-form">
                    <h3 class="danger-title">{{ __('Delete Account') }}</h3>
                    <p class="danger-text">{{ __('Warning: This action is permanent and cannot be undone.') }}</p>
                    <div class="form-group">
                        <label>{{ __('Confirm with Password') }}</label>
                        <input type="password" placeholder="{{ __('Enter your password to confirm') }}" required>
                    </div>
                    <button type="submit" class="btn btn-red">{{ __('Permanently Delete Account') }}</button>
                </form>
            </div>
        </div>

        <div class="block-card profile-history-card">
            <h2>{{ __('My Adoption Applications') }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Animal') }}</th>
                        <th>{{ __('Comment') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12.05.2026</td>
                        <td>Bella(Rabbit)</td>
                        <td>Looking for a friendly pet.</td>
                        <td><span class="stat-green-num">{{ __('Approved') }}</span></td>
                    </tr>
                </tbody>
            </table>

            <br><br>
            <h2>{{ __('My Scheduled Visits') }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Animal') }}</th>
                        <th>{{ __('Comment') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15.06.2026</td>
                        <td>Rīga</td>
                        <td>Bella(Rabbit)</td>
                        <td>Want to meet the bunny before adopting.</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>