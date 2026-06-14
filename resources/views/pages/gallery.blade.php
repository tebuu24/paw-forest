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
        
    <section class="gallery-grid" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; width: 100%;">
    @php
        $allAnimals = \App\Models\Animal::orderBy('id', 'desc')->get();
    @endphp

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
                        {{ $animal->age ?? 'N/A' }} {{ __('years') }}, 
                        {{ $animal->location->name ?? __('Unknown Location') }}
                    </p>
                    <a href="/admin/animals/{{ $animal->id }}/edit" class="btn btn-green">{{ __('View Profile') }}</a>
                </div>
            </div>
        @endforeach
    @else
        <div class="block-card" style="text-align: center; color: #8a7a74; font-style: italic; padding: 40px; width: 100%;">
            {{ __('No database records found.') }}
        </div>
    @endif
    </section>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>