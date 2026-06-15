<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Paw Forest</title>
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('favicon.ico') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}?v={{ time() }}">
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

        @php
            // Get the IDs of all animals that have an approved adoption record
            $adoptedAnimalIds = \App\Models\Adoption::where('status', 'Approved')
                ->pluck('animal_id')
                ->toArray();

            $adoptedCount = count($adoptedAnimalIds);
            
            // Filter out animals that are adopted, and ensure soft-deleted entries are ignored
            $needingHomeCount = \App\Models\Animal::whereNotIn('id', $adoptedAnimalIds)->count();
            
            $latestDonationsSum = class_exists('\App\Models\Donation') ? \App\Models\Donation::sum('amount') : 2500;
        @endphp

        <div class="stats-row">
            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">{{ __('Animals Adopted') }}</div>
                <div class="num stat-green-num">{{ $adoptedCount }}</div>
            </div>

            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">{{ __('Animals Needing a Home') }}</div>
                <div class="num stat-red-num">{{ $needingHomeCount }}</div>
            </div>

            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">{{ __('Total Donations') }}</div>
                <div class="num stat-purple-num">${{ number_format($latestDonationsSum, 0, '.', ',') }}</div>
            </div>
        </div>

        <h2 id="gallery" style="text-align: center; font-size: 2.2rem; margin-top: 40px; margin-bottom: 20px;">
            {{ __('Recently added') }}
        </h2>
        
        @if(isset($recentAnimals) && $recentAnimals->count() > 0)
            <section class="gallery-grid" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; width: 100%;">
                @foreach($recentAnimals as $animal)
                    {{-- Only display the card if the animal ID isn't in the collection of approved adoptions --}}
                    @if(!in_array($animal->id, $adoptedAnimalIds))
                        <div class="animal-card block-card" style="flex: 1 1 250px; max-width: 300px; margin: 0;">
                            @if($animal->image)
                                <img src="{{ asset($animal->image) }}" alt="{{ $animal->name }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                            @else
                                <div class="img-placeholder" style="height: 200px; display: flex; align-items: center; justify-content: center; background: #e2dcd8; border-radius: 8px 8px 0 0;">🐾 No Image</div>
                            @endif
                            <div class="card-info">
                                <h2>{{ $animal->name }}</h2>
                                <p>
                                    {{ __($animal->species) }}, 
                                    {{ $animal->age !== null ? trans_choice('{0} 0 years|{1} :count year|[2,*] :count years', $animal->age, ['count' => $animal->age]) : __('N/A') }},
                                    {{ $animal->location ? trim(str_ireplace('Shelter', '', $animal->location->name)) : __('Unknown Location') }}
                                </p>
                                <a href="/gallery/{{ $animal->id }}" class="btn btn-green">{{ __('View Profile') }}</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </section>
        @else
            <div class="block-card" style="text-align: center; color: #8a7a74; font-style: italic; padding: 40px; margin-bottom: 30px;">
                {{ __('No database records found.') }}
            </div>
        @endif

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
    @livewireStyles
</body>
</html>