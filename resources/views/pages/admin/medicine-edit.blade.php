<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Edit Medication') }}</title>
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
                    <li class="active"><a href="/admin/medicine">{{ __('Medications') }}</a></li>
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
                <h1>{{ __('Edit Medication Log') }}</h1>
                <br>

                <div class="block-card block-card-padded">
                    <form action="/admin/medicine/{{ $med->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group-spacing">
                            <label class="form-label-bold-block">{{ __('Patient Animal') }} *</label>
                            <select name="animal_id" required class="form-control-field">
                                @foreach(\App\Models\Animal::all() as $an)
                                    <option value="{{ $an->id }}" {{ $med->animal_id == $an->id ? 'selected' : '' }}>
                                        #{{ $an->id }} {{ $an->name }} ({{ $an->species }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-spacing">
                            <label class="form-label-bold-block">{{ __('Medicine Name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $med->name) }}" required class="form-control-field">
                        </div>

                        <div class="form-group-spacing">
                            <label class="form-label-bold-block">{{ __('Description') }}</label>
                            <input type="text" name="description" value="{{ old('description', $med->description) }}" required class="form-control-field">
                        </div>

                        <div class="form-group-spacing">
                            <label class="form-label-bold-block">{{ __('Method of Use') }}</label>
                            <input type="text" name="method_of_use" value="{{ old('method_of_use', $med->method_of_use) }}" placeholder="e.g. Orally" required class="form-control-field">
                        </div>

                        <div class="form-group-spacing">
                            <label class="form-label-bold-block">{{ __('Frequency') }}</label>
                            <input type="text" name="frequency" value="{{ old('frequency', $med->frequency) }}" placeholder="e.g. 1x day" required class="form-control-field">
                        </div>

                        <div class="form-group-spacing">
                            <label class="form-label-bold-block">{{ __('Date From') }}</label>
                            <input type="date" name="date_from" value="{{ old('date_from', $med->date_from) }}" required class="form-control-field">
                        </div>

                        <div class="form-group-spacing-large">
                            <label class="form-label-bold-block">{{ __('Date Until') }}</label>
                            <input type="date" name="date_until" value="{{ old('date_until', $med->date_until) }}" required class="form-control-field">
                        </div>

                        <div class="action-flex-gap-sm">
                            <button type="submit" class="btn btn-green">{{ __('Save Changes') }}</button>
                            <a href="/admin/medicine" class="btn btn-cancel-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>

                    @if(in_array(auth()->user()->role, ['admin', 'employee']))
                        <div class="danger-zone-divider">
                            <div class="danger-zone-card">
                                <h4 class="danger-zone-title">⚠️ {{ __('Danger Zone Management') }}</h4>
                                <p class="danger-zone-description">{{ __("Do you wish to modify or completely clean up this medicine log item status?") }}</p>
                                
                                <div class="action-flex-wrap-gap-md">
                                    @if(!$med->trashed())
                                        <form action="/admin/medicine/{{ $med->id }}" method="POST" onsubmit="return confirm('{{ __('Vai arhivēt šo ierakstu?') }}')" class="inline-form">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red danger-zone-btn">
                                                {{ __('Archive') }}
                                            </button>
                                        </form>
                                    @else
                                        <form action="/admin/medicine/{{ $med->id }}/restore" method="POST" class="inline-form">
                                            @csrf 
                                            <button type="submit" class="btn btn-green danger-zone-btn danger-zone-btn-success">
                                                {{ __('Restore Medication Record') }}
                                            </button>
                                        </form>

                                        @if(auth()->user()->role === 'admin')
                                            <form action="/admin/medicine/{{ $med->id }}/force-delete" method="POST" onsubmit="return confirm('UZMANĪBU! Šī darbība neatgriezeniski dzēsīs datus datus no sistēmas. Turpināt?')" class="inline-form">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-red danger-zone-btn danger-zone-btn-crimson">
                                                    {{ __('Force Delete Permanently') }}
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>