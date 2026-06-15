<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Animals') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
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
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <h1>{{ __('Manage Animals Database') }}</h1>
            <br>

            @if(session('error'))
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if(session('status'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px;">
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
                            <th>{{ __('Gender') }}</th>
                            <th>{{ __('Health Status') }}</th>
                            <th>{{ __('Shelter Location') }}</th>
                            <th>{{ __('Date Added') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                            <tr class="inline-add-row" style="background-color: #fdfbf7;">
                                <td><span class="auto-id" style="font-weight: bold; color: #8a7a74;">{{ __('Auto') }}</span></td>
                                <td><input type="file" form="create-animal-form" name="image" accept="image/*" class="table-file-upload" style="max-width: 130px;"></td>
                                <td><input type="text" form="create-animal-form" name="name" placeholder="{{ __('e.g. Buddy') }}" required style="width: 100%; box-sizing: border-box; background: #fff;"></td>
                                <td><input type="text" form="create-animal-form" name="species" placeholder="{{ __('e.g. Dog') }}" required style="width: 100%; box-sizing: border-box; background: #fff;"></td>
                                <td><input type="text" form="create-animal-form" name="breed" placeholder="{{ __('e.g. Golden') }}" required style="width: 100%; box-sizing: border-box; background: #fff;"></td>
                                <td>
                                    <select form="create-animal-form" name="gender" style="width: 100%; box-sizing: border-box; background: #fff;">
                                        <option value="Male">{{ __('Male') }}</option>
                                        <option value="Female">{{ __('Female') }}</option>
                                    </select>
                                </td>
                                <td><input type="text" form="create-animal-form" name="health_status" placeholder="{{ __('e.g. Healthy') }}" required style="width: 100%; box-sizing: border-box; background: #fff;"></td>
                                <td>
                                    <select form="create-animal-form" name="location_id" required style="width: 100%; box-sizing: border-box; background: #fff;">
                                        @foreach(\App\Models\Location::all() as $loc)
                                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="date" form="create-animal-form" name="date_added" required style="width: 100%; box-sizing: border-box; background: #fff;"></td>
                                <td>
                                    <button type="submit" form="create-animal-form" class="btn btn-green table-inline-btn" style="width: 100%;">{{ __('Save') }}</button>
                                </td>
                            </tr>
                        @endif
                        
                        @if($allAnimals->count() > 0)
                            @foreach($allAnimals as $animal)
                                <tr style="{{ $animal->trashed() ? 'background-color: #fcf8e3; opacity: 0.85;' : '' }}">
                                    <td>#{{ sprintf('%03d', $animal->id) }}</td>
                                    <td>
                                        <div style="width: 45px; height: 45px; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #bbaaa2;">
                                            @if($animal->image)
                                                <img src="{{ asset($animal->image) }}" alt="{{ $animal->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div style="width: 100%; height: 100%; background-color: #e2dcd8; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                                    🐾
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $animal->name }}</strong>
                                        @if($animal->trashed())
                                            <small style="color: #b94a48; display: block; font-weight: bold;">({{ __('Archived') }})</small>
                                        @endif
                                    </td>
                                    <td>{{ __($animal->species) }}</td>
                                    <td>{{ __($animal->breed) }}</td>
                                    <td>{{ __($animal->gender) }}</td>
                                    <td>{{ __($animal->health_status) }}</td>
                                    <td>{{ $animal->location->name ?? __('Unknown Location') }}</td>
                                    <td>
                                        {{ $animal->date_added ? \Carbon\Carbon::parse($animal->date_added)->format('Y-m-d') : '-' }}
                                    </td>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px;">
                                            <h5 style="margin: 0 0 5px 0; font-weight: bold;">⚠️ {{ __('Please correct the following errors:') }}</h5>
                                            <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <td class="table-actions">
                                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                            @if($animal->trashed())
                                                <div style="display: flex; gap: 4px;">
                                                    <form id="restore-form-{{ $animal->id }}" action="{{ route('animals.restore', $animal->id) }}" method="POST" style="display:none;">
                                                        @csrf
                                                    </form>
                                                    <button type="submit" form="restore-form-{{ $animal->id }}" class="btn btn-green" style="white-space: nowrap; padding: 6px 10px; font-size: 0.8rem;">
                                                         {{ __('Restore') }}
                                                    </button>

                                                    @if(auth()->user()->role === 'admin')
                                                        <form id="force-delete-form-{{ $animal->id }}" action="/admin/animals/{{ $animal->id }}/force-delete" method="POST" onsubmit="return confirm('{{ __('Pilnībā dzēst dzīvnieku neatgriezeniski?') }}')" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="submit" form="force-delete-form-{{ $animal->id }}" class="btn btn-red" style="white-space: nowrap; padding: 6px 10px; font-size: 0.8rem;">
                                                            {{ __('Force Delete') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="/admin/animals/{{ $animal->id }}/edit" class="btn btn-blue" style="margin-bottom: 2px; display: inline-block; white-space: nowrap;">{{ __('Edit') }}</a>
                                            @endif
                                        @else
                                            <span style="color: #8a7a74; font-style: italic;">{{ __('Read Only') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
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