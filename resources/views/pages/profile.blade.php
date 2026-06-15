<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Profile') }}</title>
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
                <a href="/donations">{{ __('Donate') }}</a> <span>|</span>
                @auth
                    <a href="/profile"><b>{{ __('Profile') }}</b></a>

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

    <main class="container profile-layout">
        
        <div style="grid-column: 1 / -1; width: 100%;">
            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-size: 0.95rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px; font-size: 0.95rem;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ __($error) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        
        <div class="profile-left-column">
            <div class="block-card profile-info-card">
                <h2>{{ __('Edit Profile Information') }}</h2>
                
                <form method="POST" action="/profile/update">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">{{ __('Full Name') }}</label>
                        <input type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', auth()->user()->name) }}" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="username">{{ __('Username') }}</label>
                        <input type="text" 
                            id="username" 
                            name="username" 
                            value="{{ old('username', auth()->user()->username) }}" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', auth()->user()->email) }}" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="address">{{ __('Address') }}</label>
                        <input type="text" 
                            id="address" 
                            name="address" 
                            placeholder="{{ __('Street, City, Postal Code') }}"
                            value="{{ old('address', auth()->user()->address) }}" 
                            required>
                    </div>

                    <button type="submit" class="btn btn-blue profile-update-btn">
                        {{ __('Save Changes') }}
                    </button>
                </form>
            </div>

            <div class="block-card profile-security-card">
                <h2>{{ __('Security Settings') }}</h2>
                
                <form method="POST" action="/profile/password" class="security-form">
                    @csrf
                    @method('PUT')
                    <h3>{{ __('Change Password') }}</h3>
                    <div class="form-group">
                        <label>{{ __('Current Password') }}</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-blue">{{ __('Change Password') }}</button>
                    </div>
                </form>
                
                <hr class="security-divider">

                <form method="POST" action="/profile/delete" class="security-form" onsubmit="return confirm('{{ __('Are you sure you want to delete your account permanently?') }}');">
                    @csrf
                    @method('DELETE')
                    <h3 class="danger-title">{{ __('Delete Account') }}</h3>
                    <p class="danger-text">{{ __('Warning: This action is permanent and cannot be undone.') }}</p>
                    <div class="form-group">
                        <label>{{ __('Confirm with Password') }}</label>
                        <input type="password" name="delete_password" placeholder="{{ __('Enter your password to confirm') }}" required>
                    </div>
                    <button type="submit" class="btn btn-red">{{ __('Permanently Delete Account') }}</button>
                </form>
            </div>
        </div>

        <div class="block-card profile-history-card">
            <h2>{{ __('My Adoption Applications') }}</h2>
            @if(auth()->user()->adoptionRequests && auth()->user()->adoptionRequests->count() > 0)
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
                        @foreach(auth()->user()->adoptionRequests as $application)
                            <tr>
                                <td>{{ $application->date }}</td>
                                <td>
                                    {{ $application->animal->name ?? __('Unknown') }} 
                                    ({{ $application->animal->species ?? __('N/A') }})
                                </td>
                                <td>{{ $application->comment }}</td>
                                <td>
                                    @if(strtolower($application->status) == 'approved')
                                        <span class="stat-green-num">{{ __($application->status) }}</span>
                                    @elseif(strtolower($application->status) == 'rejected')
                                        <span class="stat-red-num">{{ __($application->status) }}</span>
                                    @else
                                        <span class="stat-purple-num">{{ __($application->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #8a7a74; font-style: italic; margin-top: 10px;">{{ __('You have not submitted any adoption applications yet.') }}</p>
            @endif
            
            <br><br>
            
            <h2>{{ __('My Scheduled Visits') }}</h2>
            @if(auth()->user()->shelterVisits && auth()->user()->shelterVisits->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Comment') }}</th>
                            <th>{{ __('Status') }}</th> </tr>
                    </thead>
                    <tbody>
                        @foreach(auth()->user()->shelterVisits as $visit)
                            <tr>
                                <td>{{ $visit->date }}</td>
                                <td>{{ $visit->location->city_name ?? ($visit->shelter_location ?? __('Main Shelter')) }}</td>
                                <td>
                                    @if($visit->animal)
                                        {{ $visit->animal->name }} ({{ $visit->animal->species }})
                                    @else
                                        {{ __('General Visit') }}
                                    @endif
                                </td>
                                <td>{{ $visit->comment }}</td>
                                <td>@if(isset($visit->status))
                                        @if(strtolower($visit->status) == 'approved')
                                            <span class="stat-green-num">{{ __($visit->status) }}</span>
                                        @elseif(strtolower($visit->status) == 'rejected')
                                            <span class="stat-red-num">{{ __($visit->status) }}</span>
                                        @else
                                            <span class="stat-purple-num">{{ __($visit->status) }}</span>
                                        @endif
                                    @else
                                        <span class="stat-purple-num">{{ __('Pending') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #8a7a74; font-style: italic; margin-top: 10px;">{{ __('You have no scheduled shelter visits yet.') }}</p>
            @endif
        </div>

    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>