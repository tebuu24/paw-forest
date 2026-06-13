<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Animal Medications') }}</title>
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
                    <li class="active"><a href="/admin/medicine">{{ __('Medications') }}</a></li>
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
                <a href="/login" class="btn btn-red logout-btn">{{ __('Log out') }}</a>
            </div>
        </aside>

        <main class="admin-main">
            <h1>{{ __('Animal Medications Log') }}</h1>
            <br>

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Medication') }}</th>
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
                        <tr>
                            <td>#M55</td>
                            <td>#001</td>
                            <td>Apoquel</td>
                            <td>Allergy relief</td>
                            <td>Orally</td>
                            <td>Once a day</td>
                            <td>2026-06-01</td>
                            <td>2026-06-30</td>
                            <td>#E12</td>
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