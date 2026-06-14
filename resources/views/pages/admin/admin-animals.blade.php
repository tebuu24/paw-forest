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
                    
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin/locations">{{ __('Locations') }}</a></li>
                        <li><a href="/admin/users">{{ __('Users') }}</a></li>
                    @endif
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

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
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
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="text" placeholder="{{ __('e.g. Buddy') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Dog') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Golden') }}" required></td>
                            <td>
                                <select>
                                    <option value="Male">{{ __('Male') }}</option>
                                    <option value="Female">{{ __('Female') }}</option>
                                </select>
                            </td>
                            <td><input type="text" placeholder="{{ __('e.g. Healthy') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Riga') }}" required></td>
                            <td><input type="date" required></td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>
                        
                        @php
                            $animals = \App\Models\Animal::all();
                        @endphp

                        @if($animals->count() > 0)
                            @foreach($animals as $animal)
                                <tr>
                                    <td>#{{ sprintf('%03d', $animal->id) }}</td>
                                    <td>{{ $animal->name }}</td>
                                    <td>{{ __($animal->species) }}</td>
                                    <td>{{ __($animal->breed) }}</td>
                                    <td>{{ __($animal->gender) }}</td>
                                    <td>{{ __($animal->health_status) }}</td>
                                    <td>
                                        {{ $animal->location->name ?? __('Unknown Location') }}
                                    </td>
                                    <td>
                                        @if($animal->date_added)
                                            {{ \Carbon\Carbon::parse($animal->date_added)->format('Y-m-d') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="table-actions">
                                        <a href="/admin/animals/{{ $animal->id }}/edit" class="btn btn-blue">{{ __('Edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
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