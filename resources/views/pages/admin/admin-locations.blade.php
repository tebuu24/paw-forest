<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Shelter Locations') }}</title>
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
                <form id="logout-form" action="/logout" method="POST" class="hidden-element">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <h1>{{ __('Manage Shelter Locations') }}</h1>
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
                            <tr class="inline-add-row inline-creation-bg">
                                <td><span class="auto-id creation-placeholder-text">{{ __('Auto') }}</span></td>
                                <td><input type="text" form="create-location-form" name="name" placeholder="{{ __('e.g. Valmiera') }}" required class="table-input-field"></td>
                                <td><input type="text" form="create-location-form" name="address" placeholder="{{ __('e.g. Parka iela 12') }}" required class="table-input-field"></td>
                                <td><span class="status-badge-active">● {{ __('New') }}</span></td>
                                <td>
                                    <button type="submit" form="create-location-form" class="btn btn-green table-inline-btn full-width-element">{{ __('Save') }}</button>
                                </td>
                            </tr>
                        @endif

                        @foreach(\App\Models\Location::withTrashed()->get() as $location)
                            <tr class="{{ $location->trashed() ? 'archived-row-style' : '' }}">
                                <td>#L{{ sprintf('%02d', $location->id) }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->address }}</td>
                                <td>
                                    @if($location->trashed())
                                        <span class="status-badge-archived">{{ __('Archived') }}</span>
                                    @else
                                        <span class="status-badge-active">{{ __('Active') }}</span>
                                    @endif
                                </td>
                                <td class="table-actions">
                                    @if(auth()->user()->role === 'admin')
                                        <div class="action-flex-left-aligned">
                                            @if($location->trashed())
                                                <form action="/admin/locations/{{ $location->id }}/restore" method="POST" class="inline-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-green action-btn-compact">
                                                        {{ __('Restore') }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="/admin/locations/{{ $location->id }}/edit" class="btn btn-blue action-link-compact">
                                                    {{ __('Edit') }}
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <span class="read-only-label">{{ __('Read Only') }}</span>
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
