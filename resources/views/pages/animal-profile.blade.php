<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Paw Forest - Animal Profile') }}</title>
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
        <div class="profile-view-layout block-card">
            
            <div class="profile-view-img">
                @if($animal->image)
                    <img src="{{ asset($animal->image) }}" alt="{{ $animal->name }}" style="width: 100%; border-radius: 8px; max-height: 400px; object-fit: cover;">
                @else
                    <div class="img-placeholder animal-big-placeholder" style="display: flex; align-items: center; justify-content: center; background: #e2dcd8; height: 300px; border-radius: 8px;">🐾 No Image</div>
                @endif
            </div>
            
            <div class="profile-view-data">
                <h1>{{ $animal->name }}</h1>
                
                <p><b>{{ __('Species') }}:</b> {{ __($animal->species) }}</p>
                <p><b>{{ __('Breed') }}:</b> {{ $animal->breed ?? __('Unknown Breed') }}</p>
                <p><b>{{ __('Age') }}:</b>{{ $animal->age !== null ? trans_choice('{0} 0 years|{1} :count year|[2,*] :count years', $animal->age, ['count' => $animal->age]) : __('N/A') }}</p>
                <p><b>{{ __('Gender') }}:</b> {{ __($animal->gender ?? 'N/A') }}</p>
                <p><b>{{ __('Health Status') }}:</b> {{ __($animal->health_status ?? 'Healthy & Vaccinated') }}</p>
                <p><b>{{ __('Shelter Location') }}:</b> {{ $animal->location ? trim(str_ireplace('Shelter', '', $animal->location->name)) : __('Main Shelter') }}</p>
                <p><b>{{ __('Date Added to Shelter') }}:</b> {{ $animal->date_joined ?? ($animal->created_at ? $animal->created_at->format('Y-m-d') : date('Y-m-d')) }}</p>
                
                <h2 class="profile-section-title">{{ __('Description / Medication Notes') }}:</h2>

                <p style="font-style: italic; color: #8a7a74; font-size: 0.95rem; margin: 0;">{{ $animal->description ?? __('No specific notes or descriptions provided.') }}</p>

                <div class="medication-notes-block" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #e2dcd8;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 10px;"> {{ __('Active Medication & Treatment') }}</h3>
                    
                    @if($animal->medicines && $animal->medicines->count() > 0)
                            @foreach($animal->medicines as $medicine)
                                <li style="margin-bottom: 8px;">
                                    <strong>{{ $medicine->name }}</strong>
                                    @if(!empty($medicine->dosage)) 
                                        — <span style="color: #2b7a4b; font-weight: bold;">{{ $medicine->dosage }}</span>
                                    @endif
                                    @if(!empty($medicine->instructions)) 
                                        <br><small style="color: #6a5a54; font-style: italic;">{{ $medicine->instructions }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p style="font-style: italic; color: #8a7a74; font-size: 0.95rem; margin: 0;">{{ __('No active treatments or medical records found.') }}</p>
                    @endif
                </div>
                
                <div class="profile-action-buttons">
                    <a href="/apply-adoption?animal={{ $animal->id }}" class="btn btn-blue">{{ __('Apply for Adoption') }}</a>
                    <a href="/apply-visitation?animal={{ $animal->id }}" class="btn btn-green">{{ __('Apply for Visitation') }}</a>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>
</body>
</html>