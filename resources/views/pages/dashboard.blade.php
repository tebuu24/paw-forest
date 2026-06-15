<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Panel - Dashboard') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li class="active"><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li><a href="/admin/animals">{{ __('Animals') }}</a></li>
                    <li><a href="/admin/applications">{{ __('Applications') }}</a></li>
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
            <h1>{{ __('Dashboard Overview') }}</h1>

            @if(session('status'))
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 15px; margin-bottom: 20px; border-radius: 4px;">
                    {{ session('status') }}
                </div>
            @endif

            @php
                $totalAnimals = \App\Models\Animal::count();
                $pendingAdoptions = \App\Models\Adoption::where('status', 'Pending')->count();
                $totalDonations = class_exists('\App\Models\Donation') ? \App\Models\Donation::sum('amount') : 2500;
            @endphp

            <div class="stats-row">
                <div class="admin-stat-card block-card">
                    <h2>{{ __('Animals Registered') }}</h2>
                    <div class="num stat-green-num">{{ $totalAnimals }}</div>
                </div>
                <div class="admin-stat-card block-card">
                    <h2>{{ __('Pending Adoptions') }}</h2>
                    <div class="num stat-red-num">{{ $pendingAdoptions }}</div>
                </div>
                <div class="admin-stat-card block-card">
                    <h2>{{ __('Total Donations Received') }}</h2>
                    <div class="num stat-purple-num">${{ number_format($totalDonations, 0, '.', ',') }}</div>
                </div>
            </div>
            
            <section class="block-card">
                <h2>{{ __('Recent Adoption Requests') }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Application ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Employee') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentAdoptions = \App\Models\Adoption::orderBy('id', 'desc')->take(5)->get();
                        @endphp

                        @if($recentAdoptions->count() > 0)
                            @foreach($recentAdoptions as $adoption)
                                <tr>
                                    <td>#A{{ sprintf('%02d', $adoption->id) }}</td>
                                    <td>{{ $adoption->date }}</td>
                                    <td>{{ $adoption->user->name ?? __('Unknown') }}</td>
                                    <td>{{ $adoption->animal->name ?? __('Unknown') }}</td>
                                    <td>
                                        {{ $adoption->employee->user->name ?? __('Unassigned') }}
                                    </td>
                                    <td>
                                        @if(strtolower($adoption->status) === 'approved')
                                            <span class="stat-green-num">{{ __('Approved') }}</span>
                                        @elseif(strtolower($adoption->status) === 'rejected')
                                            <span class="stat-red-num">{{ __('Rejected') }}</span>
                                        @else
                                            <span class="stat-purple-num">{{ __('Pending') }}</span>
                                        @endif
                                    </td>
                                    <td class="table-actions">
                                        @if(strtolower($adoption->status) === 'pending')
                                            {{-- Operational Form Elements --}}
                                            <form action="/admin/applications/{{ $adoption->id }}/approve" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-green" style="padding: 4px 8px; font-size: 0.85rem;">{{ __('Approve') }}</button>
                                            </form>
                                            
                                            <form action="/admin/applications/{{ $adoption->id }}/reject" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-red" style="padding: 4px 8px; font-size: 0.85rem;">{{ __('Reject') }}</button>
                                            </form>
                                        @else
                                            <span style="color: #8a7a74; font-style: italic; font-size: 0.9rem;">{{ __('Decision Settled') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
                                    {{ __('No database records found.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </section>

            <section class="block-card">
                <h2>{{ __('Animal Health & Tracking') }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Animal ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Species') }}</th>
                            <th>{{ __('Health Status') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $trackedAnimals = \App\Models\Animal::orderBy('id', 'desc')->take(5)->get();
                        @endphp

                        @if($trackedAnimals->count() > 0)
                            @foreach($trackedAnimals as $animal)
                                <tr>
                                    <td>#{{ sprintf('%03d', $animal->id) }}</td>
                                    <td>{{ $animal->name }}</td>
                                    <td>{{ __($animal->species) }}</td>
                                    <td>{{ __($animal->health_status) }}</td>
                                    <td>{{ $animal->location->name ?? __('Unknown') }}</td>
                                    <td class="table-actions">
                                        {{-- Only showing the clean Edit action here --}}
                                        <a href="/admin/animals/{{ $animal->id }}/edit" class="btn btn-blue" style="padding: 4px 8px; font-size: 0.85rem; text-decoration: none; display: inline-block;">{{ __('Edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
                                    {{ __('No database records found.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>