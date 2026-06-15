<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Edit Location') }}</title>
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
            <div style="max-width: 600px; margin: 0 auto;">
                <h1>{{ __('Edit Shelter Location') }}</h1>
                <br>

                <div class="block-card" style="padding: 25px;">
                    @if(auth()->user()->role === 'admin')
                        <form action="/admin/locations/{{ $location->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Shelter Name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $location->name) }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px;">
                            </div>

                            <div style="margin-bottom: 25px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Address') }}</label>
                                <input type="text" name="address" value="{{ old('address', $location->address) }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px;">
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <button type="submit" class="btn btn-green">{{ __('Save Changes') }}</button>
                                <a href="/admin/locations" class="btn" style="background:#e2dcd8; color:#333; padding: 10px 16px; text-decoration:none; border-radius:4px; font-size: 0.9rem;">{{ __('Cancel') }}</a>
                            </div>
                        </form>

                        <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #fee2e2;">
                            <div style="background-color: #fef2f2; border: 1px solid #fca5a5; padding: 20px; border-radius: 8px;">
                                <h4 style="color: #991b1b; margin: 0 0 8px 0; font-size: 1.05rem; font-weight: bold;">⚠️ {{ __('Danger Zone Management') }}</h4>
                                <p style="color: #7f1d1d; font-size: 0.85rem; margin: 0 0 15px 0; line-height: 1.4;">
                                    {{ __('Manage database status constraints for this system physical shelter location unit.') }}
                                </p>
                                
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    <form action="/admin/locations/{{ $location->id }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this location?') }}')" style="margin:0;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red" style="padding: 10px 16px; font-size: 0.85rem; font-weight: 500;">
                                            {{ __('Archive') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px;">
                            {{ __('Access Denied. Only system administrators can update or modify physical shelter locations.') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>