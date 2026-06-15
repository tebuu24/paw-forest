<?php
use function Livewire\Volt\{state};

state(['users' => fn () => \App\Models\User::withTrashed()->orderBy('date_joined', 'desc')->get()]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Registered Users') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}"></head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li><a href="/admin/animals">{{ __('Animals') }}</a></li>
                    <li><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    
                    @if(in_array(auth()->user()->role, ['admin', 'employee']))
                        <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    @endif
                    
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
                    <li><a href="/admin/locations">{{ __('Locations') }}</a></li>
                    <li class="active"><a href="/admin/users">{{ __('Users') }}</a></li>
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
            <h1>{{ __('Registered User Profiles') }}</h1>
            <br>
            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('Password') }}</th>
                            <th>{{ __('Email Address') }}</th>
                            <th>{{ __('Registered Address') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date Joined') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr style="
                                @if($user->trashed()) background-color: #fff3cd; opacity: 0.9; 
                                @elseif($user->is_blocked) background-color: #f8d7da; 
                                @endif">
                                
                                <td>#U{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username ?? __('N/A') }}</td>
                                <td>••••••••</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address ?? __('No address specified') }}</td>
                                <td>
                                    @if($user->trashed())
                                        <span class="badge bg-warning text-dark" style="padding: 2px 6px; border-radius: 4px;">{{ __('Soft-Deleted') }}</span>
                                    @endif
                                    @if($user->is_blocked)
                                        <span class="badge bg-danger" style="padding: 2px 6px; border-radius: 4px;">{{ __('Blocked') }}</span>
                                    @else
                                        <span class="badge bg-success" style="padding: 2px 6px; border-radius: 4px;">{{ __('Active') }}</span>
                                    @endif
                                </td>
                                <td>{{ $user->date_joined ? \Carbon\Carbon::parse($user->date_joined)->format('Y-m-d') : date('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex gap-2" style="display: flex; gap: 5px;">
                                        @if(in_array(auth()->user()->role, ['admin', 'employee']))
                                            
                                            @php
                                                $currentUser = auth()->user();
                                                $canModify = false;

                                                if ($currentUser->id !== $user->id) { 
                                                    if ($currentUser->role === 'admin') {
                                                        $canModify = true; 
                                                    } elseif ($currentUser->role === 'employee' && !in_array($user->role, ['admin', 'employee'])) {
                                                        $canModify = true; 
                                                    }
                                                }
                                            @endphp

                                            @if($canModify)
                                                {{-- Block/Unblock --}}
                                                <form action="{{ url('/admin/users/'.$user->id.'/block') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-warning' }}" style="padding: 4px 8px;">
                                                        {{ $user->is_blocked ? __('Unblock') : __('Block') }}
                                                    </button>
                                                </form>

                                                {{-- Soft Delete (Deactivate) --}}
                                                @if(!$user->trashed())
                                                    <form action="{{ url('/admin/users/'.$user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-red" style="padding: 4px 8px;" onclick="return confirm('Vai tiešām deaktivizēt lietotāju?')">
                                                            {{ __('Deactivate') }}
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Restore --}}
                                                @if($user->trashed())
                                                    <form action="{{ url('/admin/users/'.$user->id.'/restore') }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-blue" style="padding: 4px 8px;">
                                                            {{ __('Restore') }}
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Force Delete (Strictly Admin only) --}}
                                                @if($user->trashed() && $currentUser->role === 'admin')
                                                    <form action="{{ url('/admin/users/'.$user->id.'/force-delete') }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-red" style="padding: 4px 8px; background-color: #d9534f;" onclick="return confirm('Pilnībā un neatgriezeniski izdzēst no DB?')">
                                                            {{ __('Force Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <span style="color: #8a7a74; font-style: italic;">{{ __('Restricted') }}</span>
                                            @endif

                                        @else
                                            <span style="color: #8a7a74; font-style: italic;">{{ __('Read Only') }}</span>
                                        @endif
                                    </div>
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