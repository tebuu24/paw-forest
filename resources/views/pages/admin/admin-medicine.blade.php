<?php
use function Livewire\Volt\{state};
?>
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
            <h1>{{ __('Animal Medications Log') }}</h1>
            <br>

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
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="text" placeholder="#000" required></td>
                            <td><input type="text" placeholder="{{ __('Name') }}" required></td>
                            <td><input type="text" placeholder="{{ __('Description') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Orally') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. 1x day') }}" required></td>
                            <td><input type="date" required></td>
                            <td><input type="date" required></td>
                            <td><input type="text" placeholder="#E00" required></td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>

                        @php
                            $medicines = \App\Models\Medicine::all();
                        @endphp

                        @if($medicines->count() > 0)
                            @foreach($medicines as $med)
                                <tr>
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
                                        <a href="/admin/medicine/{{ $med->id }}/edit" class="btn btn-blue">{{ __('Edit') }}</a>
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