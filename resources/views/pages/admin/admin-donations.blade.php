<?php
use function Livewire\Volt\{state};
?>
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
            <h1>{{ __('Donation Ledger') }}</h1>
            <br>

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
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="text" placeholder="{{ __('#U00') }}"></td>
                            <td><input type="date" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. 50.00') }}" required></td>
                            <td>
                                <select>
                                    <option value="Credit Card">{{ __('Credit Card') }}</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                                </select>
                            </td>
                            <td><input type="text" placeholder="{{ __('Optional message...') }}"></td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>

                        @php
                            // Assumes the model name follows the singular format: Donation
                            $donations = \App\Models\Donation::all();
                        @endphp

                        @if($donations->count() > 0)
                            @foreach($donations as $donation)
                                <tr>
                                    <td>#D{{ $donation->id }}</td>
                                    <td>
                                        #U{{ $donation->user_id }} 
                                        <small style="color: #8a7a74; display: block;">
                                            {{ $donation->user->name ?? '' }}
                                        </small>
                                    </td>
                                    <td>{{ $donation->date }}</td>
                                    <td>
                                        <b class="stat-green-num">
                                            ${{ number_format($donation->amount, 2) }}
                                        </b>
                                    </td>
                                    <td>{{ __($donation->method_of_payment) }}</td>
                                    <td>{{ $donation->message ?? '-' }}</td>
                                    <td class="table-actions">
                                        <a href="/admin/donations/{{ $donation->id }}/edit" class="btn btn-blue">{{ __('Edit') }}</a>
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