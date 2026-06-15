<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Donations') }}</title>
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
                        <li class="active"><a href="/admin/donations">{{ __('Donations') }}</a></li>
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
            <h1>{{ __('Donation Ledger') }}</h1>
            <br>

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

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Method of Payment') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Updated to query including soft-deleted items
                            $donations = \App\Models\Donation::withTrashed()->with('user')->get();
                        @endphp

                        @if($donations->count() > 0)
                            @foreach($donations as $donation)
                                <tr style="{{ $donation->trashed() ? 'background-color: #fcf8e3; opacity: 0.85;' : '' }}">
                                    <td>#D{{ $donation->id }}</td>
                                    <td>
                                        #U{{ $donation->user_id }} 
                                        <small style="color: #8a7a74; display: block;">
                                            {{ $donation->user->name ?? __('System User') }}
                                        </small>
                                    </td>
                                    <td>{{ $donation->date }}</td>
                                    <td>
                                        <b class="stat-green-num">
                                            €{{ number_format($donation->amount, 2) }}
                                        </b>
                                    </td>
                                    <td>{{ __($donation->method_of_payment) }}</td>
                                    <td>{{ $donation->message ?? '-' }}</td>
                                    <td class="table-actions">
                                        @if(auth()->user()->role === 'admin')
                                            <div style="display: flex; gap: 6px; align-items: center; justify-content: flex-start;">
                                                @if($donation->trashed())
                                                    <form action="/admin/donations/{{ $donation->id }}/restore" method="POST" style="margin: 0; display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green" style="padding: 6px 12px; font-size: 0.85rem; border-radius: 4px; white-space: nowrap;">
                                                            {{ __('Restore') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="/admin/donations/{{ $donation->id }}/edit" class="btn btn-blue" style="padding: 6px 12px; font-size: 0.85rem; text-decoration: none; border-radius: 4px; display: inline-block; white-space: nowrap;">
                                                        {{ __('Edit') }}
                                                    </a>
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
                                <td colspan="7" style="text-align: center; color: #8a7a74; font-style: italic; padding: 20px;">
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