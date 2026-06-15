<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Applications') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ secure_asset('favicon.ico') }}?v={{ time() }}">
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
                    <li class="active"><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    @endif
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
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
            <h1>{{ __('Adoption Requests') }}</h1>
            
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User / Applicant') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Employee Representative') }}</th>
                            <th>{{ __('Comment') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $adoptions = \App\Models\Adoption::withTrashed()->with(['user', 'animal', 'employee.user'])->get();
                        @endphp

                        @if($adoptions->count() > 0)
                            @foreach($adoptions as $adoption)
                                <tr class="{{ $adoption->trashed() ? 'row-trashed' : '' }}">
                                    <td>
                                        #A{{ sprintf('%02d', $adoption->id) }}
                                        @if($adoption->trashed())
                                            <small class="text-danger-bold">({{ __('Deleted') }})</small>
                                        @endif
                                    </td>
                                    <td>{{ $adoption->date }}</td>
                                    <td>
                                        <strong>{{ $adoption->user->name ?? __('Unknown User') }}</strong> 
                                        <span class="sub-id-text">#U{{ $adoption->user_id }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $adoption->animal->name ?? __('Unknown Animal') }}</strong>
                                        <span class="sub-id-text">#{{ $adoption->animal_id }}</span>
                                    </td>
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
                                        @if($adoption->trashed())
                                            @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                                <form id="restore-adopt-{{ $adoption->id }}" action="/admin/applications/{{ $adoption->id }}/restore" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <button type="submit" form="restore-adopt-{{ $adoption->id }}" class="btn-table-action btn-green margin-bottom-xs">
                                                    {{ __('Restore') }}
                                                </button>
                                            @endif

                                            @if(auth()->user()->role === 'admin')
                                                <form id="force-delete-adopt-{{ $adoption->id }}" action="/admin/applications/{{ $adoption->id }}/force-delete" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="submit" form="force-delete-adopt-{{ $adoption->id }}" class="btn-table-action btn-red" onclick="return confirm('Are you sure you want to permanently delete this application?')">
                                                     {{ __('Force Delete') }}
                                                </button>
                                            @endif
                                        @else
                                            @if(strtolower($adoption->status) === 'pending')
                                                <form id="approve-form-{{ $adoption->id }}" action="/admin/applications/{{ $adoption->id }}/approve" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <button type="submit" form="approve-form-{{ $adoption->id }}" class="btn-table-action btn-green">{{ __('Approve') }}</button>

                                                <form id="reject-form-{{ $adoption->id }}" action="/admin/applications/{{ $adoption->id }}/reject" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <button type="submit" form="reject-form-{{ $adoption->id }}" class="btn-table-action btn-red">{{ __('Reject') }}</button>
                                            @endif

                                            @if(in_array(strtolower($adoption->status), ['approved', 'rejected']))
                                                @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                                    <form id="archive-adopt-{{ $adoption->id }}" action="/admin/applications/{{ $adoption->id }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="submit" form="archive-adopt-{{ $adoption->id }}" class="btn-table-action btn-blue margin-top-xs" onclick="return confirm('Are you sure you want to delete this application?')">
                                                        🗑️ {{ __('Delete') }}
                                                    </button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="table-empty-state">
                                    {{ __('No adoption requests recorded.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="content-spacer"></div>
            
            <h1>{{ __('Shelter Visits') }}</h1>

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Visitor Name') }}</th>
                            <th>{{ __('Target Animal') }}</th>
                            <th>{{ __('Shelter Location') }}</th>
                            <th>{{ __('Employee Host') }}</th>
                            <th>{{ __('Comment / Purpose') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $visits = \App\Models\Visit::withTrashed()->with(['user', 'animal', 'location', 'employee.user'])->get();
                        @endphp

                        @if($visits->count() > 0)
                            @foreach($visits as $visit)
                                <tr class="{{ $visit->trashed() ? 'row-trashed' : '' }}">
                                    <td>
                                        #V{{ sprintf('%02d', $visit->id) }}
                                        @if($visit->trashed())
                                            <small class="text-danger-bold">({{ __('Deleted') }})</small>
                                        @endif
                                    </td>
                                    <td>{{ $visit->date }}</td>
                                    <td>
                                        <strong>{{ $visit->user->name ?? __('Unknown User') }}</strong>
                                        <span class="sub-id-text">#U{{ $visit->user_id }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $visit->animal->name ?? __('Unknown Animal') }}</strong>
                                        <span class="sub-id-text">#{{ $visit->animal_id }}</span>
                                    </td>
                                    <td>{{ $visit->location->name ?? __('Unknown Location') }}</td>
                                    <td>
                                        {{ $visit->employee->user->name ?? __('Unassigned') }}
                                    </td>
                                    <td>{{ $visit->comment ?? '-' }}</td>
                                    <td>
                                        @if(strtolower($visit->status ?? '') === 'approved')
                                            <span class="stat-green-num">{{ __('Approved') }}</span>
                                        @elseif(strtolower($visit->status ?? '') === 'rejected')
                                            <span class="stat-red-num">{{ __('Rejected') }}</span>
                                        @else
                                            <span class="stat-purple-num">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                    <td class="action-buttons-cell">
                                        @if($visit->trashed())
                                            @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                                <form id="restore-visit-{{ $visit->id }}" action="/admin/visits/{{ $visit->id }}/restore" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <button type="submit" form="restore-visit-{{ $visit->id }}" class="btn-table-action btn-green margin-bottom-xs">
                                                    {{ __('Restore') }}
                                                </button>
                                            @endif

                                            @if(auth()->user()->role === 'admin')
                                                <form id="force-delete-visit-{{ $visit->id }}" action="/admin/visits/{{ $visit->id }}/force-delete" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="submit" form="force-delete-visit-{{ $visit->id }}" class="btn-table-action btn-red" onclick="return confirm('Are you sure you want to permanently delete this visit record?')">
                                                    {{ __('Force Delete') }}
                                                </button>
                                            @endif
                                        @else
                                            @if(strtolower($visit->status ?? 'pending') === 'pending')
                                                <form id="visit-approve-{{ $visit->id }}" action="/admin/visits/{{ $visit->id }}/approve" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <button type="submit" form="visit-approve-{{ $visit->id }}" class="btn-table-action btn-green">{{ __('Approve') }}</button>

                                                <form id="visit-reject-{{ $visit->id }}" action="/admin/visits/{{ $visit->id }}/reject" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <button type="submit" form="visit-reject-{{ $visit->id }}" class="btn-table-action btn-red">{{ __('Reject') }}</button>
                                            @endif

                                            @if(in_array(strtolower($visit->status ?? ''), ['approved', 'rejected']))
                                                @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                                    <form id="archive-visit-{{ $visit->id }}" action="/admin/visits/{{ $visit->id }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="submit" form="archive-visit-{{ $visit->id }}" class="btn-table-action btn-blue margin-top-xs" onclick="return confirm('Are you sure you want to delete this visit record?')">
                                                        🗑️ {{ __('Delete') }}
                                                    </button>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="table-empty-state">
                                    {{ __('No scheduled visit records found.') }}
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
