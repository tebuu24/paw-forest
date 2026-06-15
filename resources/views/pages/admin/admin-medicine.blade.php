<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Animal Medications') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
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
            <div class="header-flex-container">
                <h1>{{ __('Animal Medications Log') }}</h1>
            </div>

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

            @php
                if (!isset($medicines)) {
                    $medicines = \App\Models\Medicine::withTrashed()->with(['animal', 'employee'])->get();
                }
                if (!isset($animals)) {
                    $animals = \App\Models\Animal::all();
                }
            @endphp

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Medicine Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Method of Use') }}</th>
                            <th>{{ __('Frequency') }}</th>
                            <th>{{ __('Date From') }}</th>
                            <th>{{ __('Date Until') }}</th>
                            <th>{{ __('Assigned By') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                            <form action="/admin/medicine" method="POST">
                                @csrf
                                <tr class="inline-add-row" id="inline-add">
                                    <td>
                                        <span class="auto-id">{{ __('Auto') }}</span>
                                    </td>
                                    
                                    <td>
                                        <select name="animal_id" class="table-select-field" style="width: 100%;" required>
                                            @foreach($animals as $an)
                                                <option value="{{ $an->id }}">#{{ $an->id }} {{ $an->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="name" placeholder="{{ __('Name') }}" class="table-input-field" style="width: 100%;" required></td>
                                    <td><input type="text" name="description" placeholder="{{ __('Description') }}" class="table-input-field" style="width: 100%;" required></td>
                                    <td><input type="text" name="method_of_use" placeholder="{{ __('e.g. Orally') }}" class="table-input-field" style="width: 100%;" required></td>
                                    <td><input type="text" name="frequency" placeholder="{{ __('e.g. 1x day') }}" class="table-input-field" style="width: 100%;" required></td>
                                    <td><input type="date" name="date_from" class="table-input-field" style="width: 100%;" required></td>
                                    <td><input type="date" name="date_until" class="table-input-field" style="width: 100%;" required></td>
                                    <td><span class="user-meta-tag">#E{{ auth()->user()->id }} (You)</span></td>
                                    <td><button type="submit" class="btn btn-green table-inline-btn action-btn-rounded">{{ __('Save') }}</button></td>
                                </tr>
                            </form>
                        @endif

                        @if($medicines->count() > 0)
                            @foreach($medicines as $med)
                                <tr class="{{ $med->trashed() ? 'archived-row-style' : '' }}">
                                    <td>#M{{ $med->id }}</td>
                                    <td>
                                        #{{ $med->animal_id }} {{ $med->animal->name ?? '' }}
                                    </td>
                                    <td>{{ $med->name }}</td>
                                    <td>{{ $med->description }}</td>
                                    <td>{{ __($med->method_of_use) }}</td>
                                    <td>{{ __($med->frequency) }}</td>
                                    <td>{{ $med->date_from }}</td>
                                    <td>{{ $med->date_until }}</td>
                                    <td>#E{{ $med->employee_id }} <span class="user-meta-tag">({{ $med->employee->name ?? __('Unknown') }})</span></td>
                                    <td class="table-actions">
                                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                            <div class="action-flex-left-aligned">
                                                @if($med->trashed())
                                                    <form action="/admin/medicine/{{ $med->id }}/restore" method="POST" class="inline-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green action-btn-compact">{{ __('Restore') }}</button>
                                                    </form>
                                                @else
                                                    <a href="/admin/medicine/{{ $med->id }}/edit" class="btn btn-blue action-link-compact">{{ __('Edit') }}</a>
                                                @endif
                                            </div>
                                        @else
                                            <span class="read-only-label">{{ __('Read Only') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="no-records-cell">
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
