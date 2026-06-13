<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Registered Users') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                    <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
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
                <a href="/login" class="btn btn-red logout-btn">{{ __('Log out') }}</a>
            </div>
        </aside>

        <main class="admin-main">
            <h1>{{ __('Registered User Profiles') }}</h1>
            <br>
            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('Password') }}</th>
                            <th>{{ __('Email Address') }}</th>
                            <th>{{ __('Registered Address') }}</th>
                            <th>{{ __('Date Joined') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="text" placeholder="{{ __('e.g. John Doe') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. johndoe') }}" required></td>
                            <td><input type="text" placeholder="{{ __('Temporary pass') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. john@mail.com') }}" required></td>
                            <td><input type="text" placeholder="{{ __('Street, City') }}" required></td>
                            <td><input type="date" required></td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#U44</td>
                            <td>Alice Smith</td>
                            <td>alice_smith</td>
                            <td>••••••••</td>
                            <td>alice.smith@example.com</td>
                            <td>Meowtown street 5a, Meowville</td>
                            <td>2026-01-10</td>
                            <td class="table-actions">
                                <a href="#" class="btn btn-blue">{{ __('Edit') }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>#U89</td>
                            <td>John Doe</td>
                            <td>johndoe99</td>
                            <td>••••••••</td>
                            <td>john.doe@example.com</td>
                            <td>Barking Ave 12, Riga</td>
                            <td>2026-03-22</td>
                            <td class="table-actions">
                                <a href="#" class="btn btn-blue">{{ __('Edit') }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>