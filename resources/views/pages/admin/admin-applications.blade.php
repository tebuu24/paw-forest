<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Applications') }}</title>
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
                    <li class="active"><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
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
            <h1>{{ __('Adoption Requests') }}</h1>
            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Employee') }}</th>
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
                        <tr>
                            <td>#A01</td>
                            <td>2026-05-12</td>
                            <td>#U44</td>
                            <td>#001</td>
                            <td>#E12</td>
                            <td>Has a large backyard.</td>
                            <td><span class="stat-purple-num">{{ __('Pending') }}</span></td>
                            <td class="table-actions">
                                <button class="btn btn-green">{{ __('Approve') }}</button>
                                <button class="btn btn-red">{{ __('Reject') }}</button>
                            </td>
                        </tr>
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
                            <th>{{ __('Employee') }}</th>
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
                        <tr>
                            <td>#V01</td>
                            <td>2026-06-15</td>
                            <td>#U44</td>
                            <td>#002</td>
                            <td>#L01</td>
                            <td>#E12</td>
                            <td>Wants to see cat character.</td>
                            <td class="table-actions">
                                <button class="btn btn-green">{{ __('Approve') }}</button>
                                <button class="btn btn-red">{{ __('Reject') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>