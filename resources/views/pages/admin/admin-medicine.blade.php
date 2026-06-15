<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Animal Medications') }}</title>
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
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>
        
        <main class="admin-main">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="margin: 0;">{{ __('Animal Medications Log') }}</h1>
            </div>

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

            @php
                if (!isset($medicines)) {
                    // Include trashed elements so we can find soft-deleted medications
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
                            <tr class="inline-add-row" id="inline-add">
                                <td colspan="10" style="padding: 0;">
                                    <form action="/admin/medicine" method="POST" style="display: table-row; width: 100%;">
                                        @csrf
                                        <div style="display: table-cell; padding: 12px 10px;"><span class="auto-id">{{ __('Auto') }}</span></div>
                                        <div style="display: table-cell; padding: 12px 10px;">
                                            <select name="animal_id" style="width: 100%; border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required>
                                                @foreach($animals as $an)
                                                    <option value="{{ $an->id }}">#{{ $an->id }} {{ $an->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="display: table-cell; padding: 12px 10px;"><input type="text" name="name" placeholder="{{ __('Name') }}" style="border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required></div>
                                        <div style="display: table-cell; padding: 12px 10px;"><input type="text" name="description" placeholder="{{ __('Description') }}" style="border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required></div>
                                        <div style="display: table-cell; padding: 12px 10px;"><input type="text" name="method_of_use" placeholder="{{ __('e.g. Orally') }}" style="border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required></div>
                                        <div style="display: table-cell; padding: 12px 10px;"><input type="text" name="frequency" placeholder="{{ __('e.g. 1x day') }}" style="border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required></div>
                                        <div style="display: table-cell; padding: 12px 10px;"><input type="date" name="date_from" style="border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required></div>
                                        <div style="display: table-cell; padding: 12px 10px;"><input type="date" name="date_until" style="border: 1px solid #bbaaa2; border-radius: 4px; padding: 4px;" required></div>
                                        <div style="display: table-cell; padding: 12px 10px;">
                                            <span style="font-size: 0.9rem; color:#665c54;">#E{{ auth()->user()->id }} (You)</span>
                                        </div>
                                        <div style="display: table-cell; padding: 12px 10px;">
                                            <button type="submit" class="btn btn-green table-inline-btn" style="border-radius: 4px;">{{ __('Save') }}</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endif

                        @if($medicines->count() > 0)
                            @foreach($medicines as $med)
                                <tr style="{{ $med->trashed() ? 'background-color: #fcf8e3; opacity: 0.85;' : '' }}">
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
                                    <td>#E{{ $med->employee_id }} <span style="color: #665c54; font-size: 0.9rem;">({{ $med->employee->name ?? __('Unknown') }})</span></td>
                                    <td class="table-actions">
                                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                            <div style="display: flex; gap: 6px; align-items: center; justify-content: flex-start;">
                                                @if($med->trashed())
                                                    <form action="/admin/medicine/{{ $med->id }}/restore" method="POST" style="margin: 0; display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green" style="padding: 6px 12px; font-size: 0.85rem; border-radius: 4px; white-space: nowrap;">{{ __('Restore') }}</button>
                                                    </form>
                                                @else
                                                    <a href="/admin/medicine/{{ $med->id }}/edit" class="btn btn-blue" style="padding: 6px 12px; font-size: 0.85rem; text-decoration: none; border-radius: 4px; display: inline-block; white-space: nowrap;">{{ __('Edit') }}</a>
                                                @endif
                                            </div>
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