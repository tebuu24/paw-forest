<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Paw Forest - Gallery') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('favicon.ico') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}?v={{ time() }}">
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
        
        <form method="GET" action="/gallery" class="block-card filter-section" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 30px; padding: 20px; align-items: flex-end;">
            
            <div style="flex: 1 1 200px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">{{ __('Search by Name') }}</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('e.g. Buddy...') }}" style="width: 100%; padding: 10px; border: 1px solid #e2dcd8; border-radius: 6px;">
            </div>

            <div style="flex: 1 1 150px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">{{ __('Species') }}</label>
                <select name="species" onchange="this.form.submit()" style="width: 100%; padding: 10px; border: 1px solid #e2dcd8; border-radius: 6px; background-color: white;">
                    <option value="">{{ __('All Species') }}</option>
                    <option value="Dog" {{ request('species') == 'Dog' ? 'selected' : '' }}>{{ __('Dog') }}</option>
                    <option value="Cat" {{ request('species') == 'Cat' ? 'selected' : '' }}>{{ __('Cat') }}</option>
                </select>
            </div>

            <div style="flex: 1 1 150px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">{{ __('Shelter Location') }}</label>
                <select name="location_id" onchange="this.form.submit()" style="width: 100%; padding: 10px; border: 1px solid #e2dcd8; border-radius: 6px; background-color: white;">
                    <option value="">{{ __('All Locations') }}</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                            {{ trim(str_ireplace('Shelter', '', $loc->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-blue" style="padding: 10px 20px; height: 40px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold;">
                    {{ __('Search') }}
                </button>
                <a href="/gallery" class="btn" style="padding: 10px 15px; height: 40px; display: inline-block; line-height: 20px; text-decoration: none; color: #6a5a54; background: #e2dcd8; margin-left: 5px; border-radius: 6px; font-weight: bold;">
                    ✕
                </a>
            </div>
        </form>

        <section class="gallery-grid" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; width: 100%;">
        @if($allAnimals->count() > 0)
            @foreach($allAnimals as $animal)
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
            @endforeach
        @else
            <div class="block-card" style="text-align: center; color: #8a7a74; font-style: italic; padding: 40px; width: 100%;">
                {{ __('No animals match your search criteria.') }}
            </div>
        @endif
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>