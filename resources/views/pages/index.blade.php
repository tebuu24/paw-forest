<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Forest</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @livewireStyles
</head>
<body>
    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <a href="/"><b>{{ __('Home') }}</b></a> <span>|</span>
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

    <main class="container">

        <section class="block-card hero-section">
            <p class="hero-tagline">{{ __('Open for Adoption · Est. 2020') }}</p>
            <h1 class="hero-title">{{ __('Find Your Perfect Fluffy Friend') }}</h1>
            <p class="hero-text">
                {{ __('Every resident of our shelter is waiting for a loving home. Get to know them and give someone a second chance!') }}
            </p>
            <div class="hero-buttons">
                <a href="#gallery" class="btn btn-blue">{{ __('Meet the Animals') }}</a>
            </div>
        </section>

        <div class="stats-row">
            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">{{ __('Animals Adopted') }}</div>
                <div class="num stat-green-num">124</div>
            </div>

            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">{{ __('Animals Needing a Home') }}</div>
                <div class="num stat-red-num">45</div>
            </div>

            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">{{ __('Latest Donations') }}</div>
                <div class="num stat-purple-num">$2,500</div>
            </div>
        </div>

        <h2 id="gallery">{{ __('Recently added') }}</h2>
        
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

        <div>
            <livewire:animal-fact />
        </div>

        <section class="block-card info-split-section">
            <div class="block-card info-visual-box">
                🏡
            </div>
            <div class="info-content-box">
                <span class="info-pretitle">{{ __('About Our Shelter') }}</span>
                <h2 class="info-title">{{ __('A Safe Haven Guided by Love') }}</h2>
                <p class="info-paragraph">
                    {{ __('Paw Forest is a non-profit animal shelter dedicated to finding the right home for every animal. Our staff and volunteers provide daily care, medical support, and most importantly - endless love.') }}
                </p>
                <p class="info-paragraph">
                    {{ __('Whether you are ready to adopt, help out as a foster home, or simply support us during weekends - there is always a place for kind people here.') }}
                </p>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>
    @livewireScripts
</body>
</html>