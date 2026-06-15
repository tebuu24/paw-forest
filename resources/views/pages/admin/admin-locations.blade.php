<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Shelter Locations') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li><a href="/admin/animals">{{ __('Animals') }}</a></li>
                    <li><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    @endif
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
                    <li class="active"><a href="/admin/locations">{{ __('Locations') }}</a></li>
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
            <h1>{{ __('Manage Shelter Locations') }}</h1>
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
                @if(auth()->user()->role === 'admin')
                    <form id="create-location-form" action="/admin/locations" method="POST">
                        @csrf
                    </form>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Shelter Name') }}</th>
                            <th>{{ __('Address') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(auth()->user()->role === 'admin')
                            <tr class="inline-add-row" style="background-color: #fdfbf7;">
                                <td><span class="auto-id" style="font-weight: bold; color: #8a7a74;">{{ __('Auto') }}</span></td>
                                <td><input type="text" form="create-location-form" name="name" placeholder="{{ __('e.g. Valmiera') }}" required style="width: 100%; box-sizing: border-box;"></td>
                                <td><input type="text" form="create-location-form" name="address" placeholder="{{ __('e.g. Parka iela 12') }}" required style="width: 100%; box-sizing: border-box;"></td>
                                <td><span style="color: #28a745; font-weight: bold;">● {{ __('New') }}</span></td>
                                <td>
                                    <button type="submit" form="create-location-form" class="btn btn-green table-inline-btn" style="width: 100%;">{{ __('Save') }}</button>
                                </td>
                            </tr>
                        @endif

                        @foreach(\App\Models\Location::withTrashed()->get() as $location)
                            <tr style="{{ $location->trashed() ? 'background-color: #fcf8e3; opacity: 0.85;' : '' }}">
                                <td>#L{{ sprintf('%02d', $location->id) }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->address }}</td>
                                <td>
                                    @if($location->trashed())
                                        <span style="color: #dc3545; font-weight: bold;">{{ __('Archived') }}</span>
                                    @else
                                        <span style="color: #28a745; font-weight: bold;">{{ __('Active') }}</span>
                                    @endif
                                </td>
                                <td class="table-actions">
                                    @if(auth()->user()->role === 'admin')
                                        <div style="display: flex; gap: 6px; align-items: center; justify-content: flex-start;">
                                            @if($location->trashed())
                                                <form action="/admin/locations/{{ $location->id }}/restore" method="POST" style="margin: 0; display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-green" style="padding: 6px 12px; font-size: 0.85rem; border-radius: 4px; white-space: nowrap;">
                                                        {{ __('Restore') }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="/admin/locations/{{ $location->id }}/edit" class="btn btn-blue" style="padding: 6px 12px; font-size: 0.85rem; text-decoration: none; border-radius: 4px; display: inline-block; white-space: nowrap;">
                                                    {{ __('Edit') }}
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <span style="color: #8a7a74; font-style: italic;">{{ __('Read Only') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>