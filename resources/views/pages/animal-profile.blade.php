<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Animal Profile') }}</title>
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
                <a href="/gallery"><b>{{ __('Gallery') }}</b></a> <span>|</span>
                <a href="/donations">{{ __('Donate') }}</a> <span>|</span>
                <a href="/profile">{{ __('Profile') }}</a> <span>|</span>
                <a href="/login">{{ __('Log in') }}</a> <span>|</span>
                
                <select class="lang-select" onchange="location = this.value;">
                    <option value="/lang/en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🌐 EN</option>
                    <option value="/lang/lv" {{ app()->getLocale() == 'lv' ? 'selected' : '' }}>🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="profile-view-layout block-card">
            
            <div class="profile-view-img">
                <div class="img-placeholder animal-big-placeholder"></div>
            </div>
            
            <div class="profile-view-data">
                <h1>Buddy</h1>
                
                <p><b>{{ __('Species') }}:</b> Dog</p>
                <p><b>{{ __('Breed') }}:</b> Golden Retriever</p>
                <p><b>{{ __('Age') }}:</b> 3 years</p>
                <p><b>{{ __('Gender') }}:</b> Female</p>
                <p><b>{{ __('Health Status') }}:</b> Healthy & Vaccinated</p>
                <p><b>{{ __('Shelter Location ID') }}:</b> #L01</p>
                <p><b>{{ __('Date Added to Shelter') }}:</b> 2025-04-10</p>
                
                <h2 class="profile-section-title">{{ __('Description / Medication Notes') }}:</h2>
                <p>Buddy is a friendly, active retriever. Currently receives regular flea prevention and checks.</p>
                
                <div class="profile-action-buttons">
                    <a href="/apply-adoption" class="btn btn-blue">{{ __('Apply for Adoption') }}</a>
                    <a href="/apply-visitation" class="btn btn-green">{{ __('Apply for Visitation') }}</a>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>
</body>
</html>