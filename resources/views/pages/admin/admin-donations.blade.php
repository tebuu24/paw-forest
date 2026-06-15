<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Donations') }}</title>
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
                <form id="logout-form" action="/logout" method="POST" class="hidden-element">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <h1>{{ __('Donation Ledger') }}</h1>
            <br>

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
                            $donations = \App\Models\Donation::withTrashed()->with('user')->get();
                        @endphp

                        @if($donations->count() > 0)
                            @foreach($donations as $donation)
                                <tr class="{{ $donation->trashed() ? 'archived-row-style' : '' }}">
                                    <td>#D{{ $donation->id }}</td>
                                    <td>
                                        #U{{ $donation->user_id }} 
                                        <small class="muted-block-label">
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
                                            <div class="action-flex-left-aligned">
                                                @if($donation->trashed())
                                                    <form action="/admin/donations/{{ $donation->id }}/restore" method="POST" class="inline-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-green action-btn-compact">
                                                            {{ __('Restore') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="/admin/donations/{{ $donation->id }}/edit" class="btn btn-blue action-link-compact">
                                                        {{ __('Edit') }}
                                                    </a>
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
                                <td colspan="7" class="no-records-cell">
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
