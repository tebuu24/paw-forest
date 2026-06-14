<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Applications') }}</title>
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
                    <li class="active"><a href="/admin/applications">{{ __('Applications') }}</a></li>
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
            <h1>{{ __('Adoption Requests') }}</h1>
            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Employee Representative') }}</th>
                            <th>{{ __('Comment') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="date" required></td>
                            <td><input type="text" placeholder="#U00" required></td>
                            <td><input type="text" placeholder="#000" required></td>
                            <td><input type="text" placeholder="#E00" required></td>
                            <td><input type="text" placeholder="{{ __('Notes...') }}" required></td>
                            <td>
                                <select>
                                    <option value="Pending">{{ __('Pending') }}</option>
                                    <option value="Approved">{{ __('Approved') }}</option>
                                    <option value="Rejected">{{ __('Rejected') }}</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>

                        @php
                            $adoptions = \App\Models\Adoption::all();
                        @endphp

                        @if($adoptions->count() > 0)
                            @foreach($adoptions as $adoption)
                                <tr>
                                    <td>#A{{ sprintf('%02d', $adoption->id) }}</td>
                                    <td>{{ $adoption->date }}</td>
                                    <td>#U{{ $adoption->user_id }} {{ $adoption->user->name ?? '' }}</td>
                                    <td>#{{ $adoption->animal_id }} {{ $adoption->animal->name ?? '' }}</td>
                                    <td>
                                        {{ $adoption->employee->user->name ?? __('Unassigned') }}
                                    </td>
                                    <td>{{ $adoption->comment ?? '-' }}</td>
                                    <td>
                                        @if(strtolower($adoption->status) === 'approved')
                                            <span class="stat-green-num">{{ __('Approved') }}</span>
                                        @elseif(strtolower($adoption->status) === 'rejected')
                                            <span class="stat-red-num">{{ __('Rejected') }}</span>
                                        @else
                                            <span class="stat-purple-num">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                        <td class="action-buttons-cell">
                                            <form action="/admin/applications/{{ $adoption->id }}/approve" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-table-action btn-green">{{ __('Approve') }}</button>
                                            </form>

                                            <form action="/admin/applications/{{ $adoption->id }}/reject" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-table-action btn-red">{{ __('Reject') }}</button>
                                            </form>
                                        </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
                                    {{ __('No database records found.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <br><br>
            
            <h1>{{ __('Shelter Visits') }}</h1>
            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Shelter Location') }}</th>
                            <th>{{ __('Employee Representative') }}</th>
                            <th>{{ __('Comment') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="date" required></td>
                            <td><input type="text" placeholder="#U00" required></td>
                            <td><input type="text" placeholder="#000" required></td>
                            <td><input type="text" placeholder="#L00" required></td>
                            <td><input type="text" placeholder="#E00" required></td>
                            <td><input type="text" placeholder="{{ __('Purpose...') }}" required></td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>

                        @php
                            $visits = \App\Models\Visit::all();
                        @endphp

                        @if($visits->count() > 0)
                            @foreach($visits as $visit)
                                <tr>
                                    <td>#V{{ sprintf('%02d', $visit->id) }}</td>
                                    <td>{{ $visit->date }}</td>
                                    <td>#U{{ $visit->user_id }} {{ $visit->user->name ?? '' }}</td>
                                    <td>#{{ $visit->animal_id }} {{ $visit->animal->name ?? '' }}</td>
                                    <td>#L{{ $visit->location_id }} {{ $visit->location->name ?? '' }}</td>
                                    <td>
                                        {{ $visit->employee->user->name ?? __('Unassigned') }}
                                    </td>
                                    <td>{{ $visit->comment ?? '-' }}</td>
                                        <td class="action-buttons-cell">
                                            <form action="/admin/applications/{{ $adoption->id }}/approve" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-table-action btn-green">{{ __('Approve') }}</button>
                                            </form>

                                            <form action="/admin/applications/{{ $adoption->id }}/reject" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-table-action btn-red">{{ __('Reject') }}</button>
                                            </form>
                                        </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
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

