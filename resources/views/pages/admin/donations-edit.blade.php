<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Edit Donation') }}</title>
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
            <div style="max-width: 600px; margin: 0 auto;">
                <h1>{{ __('Modify Donation Details') }}</h1>
                <br>

                <div class="block-card" style="padding: 25px;">
                    @if(auth()->user()->role === 'admin')
                        <form action="/admin/donations/{{ $donation->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Donor') }}</label>
                                <input type="text" value="#U{{ $donation->user_id }} - {{ $donation->user->name ?? __('Unknown User') }}" style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background-color: #f5f0ed; color: #665c54; cursor: not-allowed;" readonly>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Donation Date') }}</label>
                                <input type="text" value="{{ $donation->date }}" style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background-color: #f5f0ed; color: #665c54; cursor: not-allowed;" readonly>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Contribution Total Amount') }}</label>
                                <input type="text" value="€{{ number_format($donation->amount, 2) }}" style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background-color: #f5f0ed; color: #665c54; font-weight: bold; cursor: not-allowed;" readonly>
                            </div>

                            <hr style="border: 0; border-top: 1px solid #e5dfdb; margin: 20px 0;">

                            <div style="margin-bottom: 15px;">
                                <label for="method_of_payment" style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Method of Payment') }}</label>
                                <select name="method_of_payment" id="method_of_payment" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                    <option value="Credit Card" {{ $donation->method_of_payment === 'Credit Card' ? 'selected' : '' }}>{{ __('Credit Card') }}</option>
                                    <option value="PayPal" {{ $donation->method_of_payment === 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="Bank Transfer" {{ $donation->method_of_payment === 'Bank Transfer' ? 'selected' : '' }}>{{ __('Bank Transfer') }}</option>
                                </select>
                            </div>

                            <div style="margin-bottom: 25px;">
                                <label for="message" style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Message / Internal Memo') }}</label>
                                <textarea name="message" id="message" rows="3" placeholder="{{ __('Optional tracking annotations...') }}" style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; font-family: inherit;">{{ $donation->message }}</textarea>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <button type="submit" class="btn btn-green">💾 {{ __('Save Changes') }}</button>
                                <a href="/admin/donations" class="btn" style="background:#e2dcd8; color:#333; padding: 10px 16px; text-decoration:none; border-radius:4px; font-size: 0.9rem;">{{ __('Cancel') }}</a>
                            </div>
                        </form>

                        <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #fee2e2;">
                            <div style="background-color: #fef2f2; border: 1px solid #fca5a5; padding: 20px; border-radius: 8px;">
                                <h4 style="color: #991b1b; margin: 0 0 8px 0; font-size: 1.05rem; font-weight: bold;">⚠️ {{ __('Danger Zone Management') }}</h4>
                                <p style="color: #7f1d1d; font-size: 0.85rem; margin: 0 0 15px 0; line-height: 1.4;">
                                    {{ __('Manage database status constraints for this system contribution receipt record entry.') }}
                                </p>
                                
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    @if($donation->trashed())
                                        <form action="/admin/donations/{{ $donation->id }}/restore" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn btn-blue" style="padding: 10px 16px; font-size: 0.85rem;">
                                                ♻️ {{ __('Restore Entry') }}
                                            </button>
                                        </form>
                                    @else
                                        <form action="/admin/donations/{{ $donation->id }}" method="POST" onsubmit="return confirm('{{ __('Dzēst ziedojumu?') }}')" style="margin:0;">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red" style="padding: 10px 16px; font-size: 0.85rem; font-weight: 500;">
                                                📁 {{ __('Archive') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px;">
                            🔒 {{ __('Access Denied. Only system administrators can update or modify monetary ledger entries.') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>