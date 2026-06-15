<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Animals') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('favicon.ico') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="active"><a href="/admin/animals">{{ __('Animals') }}</a></li>
                    <li><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    @endif
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
                    <li><a href="/admin/locations">{{ __('Locations') }}</a></li>
                    <li><a href="/admin/users">{{ __('Users') }}</a></li>
                </ul>
            </div>
            <div class="admin-lang-container">
                <select class="lang-select admin-lang-select" onchange="location = this.value;">
                    <option value="/lang/en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🌐 EN</option>
                    <option value="/lang/lv" {{ app()->getLocale() == 'lv' ? 'selected' : '' }}>🌐 LV</option>
                </select>
            </div>
            <div>
                <a href="/" class="btn btn-blue logout-btn margin-bottom-sm">🏠 {{ __('Home') }}</a>
                <a href="#" class="btn btn-red logout-btn" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Log out') }}
                </a>
                <form id="logout-form" action="/logout" method="POST" class="hidden-element">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <h1>{{ __('Manage Animals Database') }}</h1>
            <br>

            @if(session('error'))
                <div class="alert alert-danger error-alert-box">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if(session('status'))
                <div class="alert alert-success success-alert-box">
                    {{ session('status') }}
                </div>
            @endif

            <div class="block-card">
                @if(in_array(auth()->user()->role, ['admin', 'employee']))
                    <form id="create-animal-form" action="/admin/animals" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Image') }}</th> 
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Species') }}</th>
                            <th>{{ __('Breed') }}</th>
                            <th>{{ __('Age') }}</th>
                            <th>{{ __('Gender') }}</th>
                            <th>{{ __('Health Status') }}</th>
                            <th>{{ __('Shelter Location') }}</th>
                            <th>{{ __('Date Added') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                            <tr class="inline-add-row row-light-bg">
                                <td><span class="auto-id auto-id-bold">{{ __('Auto') }}</span></td>
                                <td><input type="file" form="create-animal-form" name="image" accept="image/*" class="table-file-upload file-upload-constrained"></td>
                                <td><input type="text" form="create-animal-form" name="name" placeholder="{{ __('e.g. Buddy') }}" required class="full-width-input white-bg"></td>
                                <td><input type="text" form="create-animal-form" name="species" placeholder="{{ __('e.g. Dog') }}" required class="full-width-input white-bg"></td>
                                <td><input type="text" form="create-animal-form" name="breed" placeholder="{{ __('e.g. Golden') }}" required class="full-width-input white-bg"></td>
                                <td><input type="number" form="create-animal-form" name="age" placeholder="{{ __('e.g. 2') }}" min="0" class="full-width-input white-bg"></td>
                                <td>
                                    <select form="create-animal-form" name="gender" class="full-width-input white-bg">
                                        <option value="Male">{{ __('Male') }}</option>
                                        <option value="Female">{{ __('Female') }}</option>
                                    </select>
                                </td>
                                <td><input type="text" form="create-animal-form" name="health_status" placeholder="{{ __('e.g. Healthy') }}" required class="full-width-input white-bg"></td>
                                <td>
                                    <select form="create-animal-form" name="location_id" required class="full-width-input white-bg">
                                        @foreach(\App\Models\Location::all() as $loc)
                                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="date" form="create-animal-form" name="date_added" required class="full-width-input white-bg"></td>
                                <td>
                                    <button type="submit" form="create-animal-form" class="btn btn-green table-inline-btn full-width-btn">{{ __('Save') }}</button>
                                </td>
                            </tr>
                        @endif
                        
                        @if($allAnimals->count() > 0)
                            @foreach($allAnimals as $animal)
                                <tr class="{{ $animal->trashed() ? 'archived-row-style' : '' }}">
                                    <td>#{{ sprintf('%03d', $animal->id) }}</td>
                                    <td>
                                        <div class="table-image-container">
                                            @if($animal->image)
                                                <img src="{{ asset($animal->image) }}" alt="{{ $animal->name }}" class="table-image-element">
                                            @else
                                                <div class="table-image-fallback">
                                                    🐾
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $animal->name }}</strong>
                                        @if($animal->trashed())
                                            <small class="archived-text-label">({{ __('Archived') }})</small>
                                        @endif
                                    </td>
                                    <td>{{ __($animal->species) }}</td>
                                    <td>{{ __($animal->breed) }}</td>
                                    <td>{{ $animal->age !== null ? $animal->age . ' ' . trans_choice('year|years', $animal->age) : '-' }}</td>
                                    <td>{{ __($animal->gender) }}</td>
                                    <td>{{ __($animal->health_status) }}</td>
                                    <td>{{ $animal->location->name ?? __('Unknown Location') }}</td>
                                    <td>
                                        {{ $animal->date_added ? \Carbon\Carbon::parse($animal->date_added)->format('Y-m-d') : '-' }}
                                    </td>
                                    @if ($errors->any())
                                        <div class="alert alert-danger validation-error-box">
                                            <h5 class="validation-error-title">{{ __('Please correct the following errors:') }}</h5>
                                            <ul class="validation-error-list">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <td class="table-actions">
                                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                            @if($animal->trashed())
                                                <div class="action-flex-container">
                                                    <form id="restore-form-{{ $animal->id }}" action="{{ route('animals.restore', $animal->id) }}" method="POST" class="hidden-element">
                                                        @csrf
                                                    </form>
                                                    <button type="submit" form="restore-form-{{ $animal->id }}" class="btn btn-green action-btn-compact">
                                                         {{ __('Restore') }}
                                                    </button>

                                                    @if(auth()->user()->role === 'admin')
                                                        <form id="force-delete-form-{{ $animal->id }}" action="/admin/animals/{{ $animal->id }}/force-delete" method="POST" onsubmit="return confirm('{{ __('Pilnībā dzēst dzīvnieku neatgriezeniski?') }}')" class="hidden-element">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="submit" form="force-delete-form-{{ $animal->id }}" class="btn btn-red action-btn-compact">
                                                            {{ __('Force Delete') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="/admin/animals/{{ $animal->id }}/edit" class="btn btn-blue action-link-compact">{{ __('Edit') }}</a>
                                            @endif
                                        @else
                                            <span class="read-only-label">{{ __('Read Only') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="no-records-cell">
                                    {{ __('No database records found.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>