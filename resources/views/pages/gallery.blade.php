<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Gallery') }}</title>
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
                <a href="/gallery"><b>{{ __('Gallery') }}</b></a> <span>|</span>
                <a href="/donations">{{ __('Donate') }}</a> <span>|</span>
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

    <main class="container">
        <br>
        <h1>{{ __('Our Shelter Gallery') }}</h1>
        
        <div class="search-bar-container">
            <div class="search-inputs">
                <input type="text" placeholder="{{ __('Search by species, age, location') }}" class="block-card">
                <button class="btn btn-blue">{{ __('Search') }}</button>
            </div>
            <div>
                <select class="block-card">
                    <option>{{ __('Sort by: Most Recently Added') }}</option>
                    <option>{{ __('Sort by: Age') }}</option>
                </select>
            </div>
        </div>

        <section class="gallery-grid">
            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Buddy</h2>
                    <p>Dog, 3 years, Riga</p>
                    <a href="/animal-profile" class="btn btn-green">{{ __('View Profile') }}</a>
                </div>
            </div>
            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Whiskers</h2>
                    <p>Cat, 1 year, Rezekne</p>
                    <a href="/animal-profile" class="btn btn-green">{{ __('View Profile') }}</a>
                </div>
            </div>
            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Rocky</h2>
                    <p>Rabbit, 6 months, Ventspils</p>
                    <a href="/animal-profile" class="btn btn-green">{{ __('View Profile') }}</a>
                </div>
            </div>
            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Goldie</h2>
                    <p>Fish, 2 months, Riga</p>
                    <a href="/animal-profile" class="btn btn-green">{{ __('View Profile') }}</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>