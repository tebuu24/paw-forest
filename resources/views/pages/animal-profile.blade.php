<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Paw Forest - Animal Profile') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
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
        <div class="profile-view-layout block-card">
            
            <div class="profile-view-img">
                @if($animal->image)
                    <img src="{{ asset($animal->image) }}" alt="{{ $animal->name }}" class="animal-profile-image">
                @else
                    <div class="img-placeholder animal-big-placeholder">🐾 No Image</div>
                @endif
            </div>
            
            <div class="profile-view-data">
                <h1>{{ $animal->name }}</h1>
                
                <p><b>{{ __('Species') }}:</b> {{ __($animal->species) }}</p>
                <p><b>{{ __('Breed') }}:</b> {{ $animal->breed ?? __('Unknown Breed') }}</p>
                <p><b>{{ __('Age') }}:</b> {{ $animal->age !== null ? trans_choice('{0} 0 years|{1} :count year|[2,*] :count years', $animal->age, ['count' => $animal->age]) : __('N/A') }}</p>
                <p><b>{{ __('Gender') }}:</b> {{ __($animal->gender ?? 'N/A') }}</p>
                <p><b>{{ __('Health Status') }}:</b> {{ __($animal->health_status ?? 'Healthy & Vaccinated') }}</p>
                <p><b>{{ __('Shelter Location') }}:</b> {{ $animal->location ? trim(str_ireplace('Shelter', '', $animal->location->name)) : __('Main Shelter') }}</p>
                <p><b>{{ __('Date Added to Shelter') }}:</b> {{ $animal->date_joined ?? ($animal->created_at ? $animal->created_at->format('Y-m-d') : date('Y-m-d')) }}</p>
                

                <div class="medication-notes-block">
                    <h3>{{ __('Active Medication & Treatment') }}</h3>
                    
                    @if($animal->medicines && $animal->medicines->count() > 0)
                        <ul class="medication-list">
                            @foreach($animal->medicines as $medicine)
                                <li>
                                    <strong>{{ $medicine->name }}</strong>
                                    @if(!empty($medicine->dosage)) 
                                        — <span class="medicine-dosage">{{ $medicine->dosage }}</span>
                                    @endif
                                    @if(!empty($medicine->instructions)) 
                                        <br><small class="medicine-instructions">{{ $medicine->instructions }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="no-notes-text">{{ __('No active treatments or medical records found.') }}</p>
                        <br>
                    @endif
                </div>
                
                <div class="profile-action-container" style="display: flex; flex-direction: column; gap: 15px; width: 100%; max-width: 500px;">
                    <div class="profile-action-buttons" style="display: flex; align-items: center; gap: 10px; margin: 0; padding: 0;">
                        @auth
                            <button type="button" class="btn btn-blue" onclick="openAdoptionModal()">
                                {{ __('Apply for Adoption') }}
                            </button>
                        @else
                            <a href="/login" class="btn btn-blue text-link-btn">
                                {{ __('Log in to Adopt') }}
                            </a>
                        @endauth

                        @auth
                            <button type="button" class="btn btn-green" onclick="openVisitModal()">
                                {{ __('Apply for Visitation') }}
                            </button>
                        @else
                            <a href="/login" class="btn btn-blue text-link-btn">
                                {{ __('Log in to Apply for Visitation') }}
                            </a>
                        @endauth
                    </div>

                    @if(session('success'))
                        <div class="alert-box alert-success-custom" style="width: 100%; box-sizing: border-box; margin: 0;">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

    <div id="adoptionModal" class="modal-overlay">
        <div class="block-card modal-content modal-content-large">
            <span onclick="closeAdoptionModal()" class="modal-close-btn">&times;</span>
            
            <h2>{{ __('Adoption Application') }}</h2>
            <p class="modal-subtitle">
                {{ __('You are applying to adopt') }} <b>{{ $animal->name }}</b>. {{ __('Please introduce yourself and explain why you want to provide a forever home for this animal.') }}
            </p>

            <form method="POST" action="{{ route('adoptions.store') }}">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $animal->id }}">

                <div class="form-group form-spacer">
                    <label class="modal-label">{{ __('Motivation / Living Conditions Message') }}</label>
                    <textarea name="comment" class="modal-textarea" placeholder="{{ __('Tell us a bit about your home environment, experience with pets, and why you chose this specific animal...') }}" required></textarea>
                    <small class="modal-help-text">{{ __('Please write at least a few sentences.') }}</small>
                </div>

                <div class="modal-footer-actions">
                    <button type="button" class="btn modal-cancel-btn" onclick="closeAdoptionModal()">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-green">
                        {{ __('Submit Application') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="visitModal" class="modal-overlay">
        <div class="block-card modal-content">
            <span onclick="closeVisitModal()" class="modal-close-btn">&times;</span>
            
            <h2>{{ __('Apply for a Visit') }}</h2>
            <p class="modal-subtitle">
                {{ __('You are applying to visit') }} <b>{{ $animal->name }}</b> {{ __('at') }} {{ $animal->location ? trim(str_ireplace('Shelter', '', $animal->location->name)) : __('our shelter') }}.
            </p>

            <form method="POST" action="{{ route('visits.store') }}">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $animal->id }}">

                <div class="form-row-split form-spacer">
                    <div class="split-field">
                        <label class="modal-label">{{ __('Select Date') }}</label>
                        <input type="date" name="visit_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                    <div class="split-field">
                        <label class="modal-label">{{ __('Select Time') }}</label>
                        <input type="time" name="visit_time" required>
                    </div>
                </div>

                <div class="form-group form-spacer">
                    <label class="modal-label">{{ __('Message / Comment') }}</label>
                    <textarea name="comment" class="modal-textarea-short" placeholder="{{ __('Why would you like to visit this animal? Do you have any questions?') }}"></textarea>
                </div>

                <div class="modal-footer-actions">
                    <button type="button" class="btn modal-cancel-btn" onclick="closeVisitModal()">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-green">
                        {{ __('Submit Application') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAdoptionModal() {
            document.getElementById('adoptionModal').style.display = 'flex';
        }

        function closeAdoptionModal() {
            document.getElementById('adoptionModal').style.display = 'none';
        }

        function openVisitModal() {
            document.getElementById('visitModal').style.display = 'flex';
        }

        function closeVisitModal() {
            document.getElementById('visitModal').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            var visitModal = document.getElementById('visitModal');
            var adoptionModal = document.getElementById('adoptionModal');
            
            if (event.target == visitModal) {
                visitModal.style.display = 'none';
            }
            if (event.target == adoptionModal) {
                adoptionModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
