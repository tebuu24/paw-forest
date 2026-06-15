<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Edit Location') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
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
                <a href="#" class="btn btn-red logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Log out') }}
                </a>
                <form id="logout-form" action="/logout" method="POST" class="hidden-element">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <div class="form-narrow-wrapper">
                <h1>{{ __('Edit Shelter Location') }}</h1>
                <br>

                <div class="block-card block-card-padded">
                    @if(auth()->user()->role === 'admin')
                        <form action="/admin/locations/{{ $location->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group-spacing">
                                <label class="form-label-bold-block">{{ __('Shelter Name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $location->name) }}" required class="form-control-field">
                            </div>

                            <div class="form-group-spacing-large">
                                <label class="form-label-bold-block">{{ __('Address') }}</label>
                                <input type="text" name="address" value="{{ old('address', $location->address) }}" required class="form-control-field">
                            </div>

                            <div class="action-flex-gap-sm">
                                <button type="submit" class="btn btn-green">{{ __('Save Changes') }}</button>
                                <a href="/admin/locations" class="btn btn-cancel-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>

                        <div class="danger-zone-divider">
                            <div class="danger-zone-card">
                                <h4 class="danger-zone-title">⚠️ {{ __('Danger Zone Management') }}</h4>
                                <p class="danger-zone-description">
                                    {{ __('Manage database status constraints for this system physical shelter location unit.') }}
                                </p>
                                
                                <div class="action-flex-wrap-gap-md">
                                    <form action="/admin/locations/{{ $location->id }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this location?') }}')" class="inline-form">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red danger-zone-btn">
                                            {{ __('Archive') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger custom-alert-denied">
                            {{ __('Access Denied. Only system administrators can update or modify physical shelter locations.') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>