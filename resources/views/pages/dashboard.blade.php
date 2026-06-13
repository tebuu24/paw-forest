<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Panel - Dashboard') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
            <h1>{{ __('Dashboard Overview') }}</h1>

            <div class="stats-row">
                <div class="admin-stat-card block-card">
                    <h2>{{ __('Animals Registered') }}</h2>
                    <div class="num stat-green-num">169</div>
                </div>
                <div class="admin-stat-card block-card">
                    <h2>{{ __('Pending Adoptions') }}</h2>
                    <div class="num stat-red-num">14</div>
                </div>
                <div class="admin-stat-card block-card">
                    <h2>{{ __('Total Donations Received') }}</h2>
                    <div class="num stat-purple-num">$2,500</div>
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
                        <tr>
                            <td>#A01</td>
                            <td>2026-06-12</td>
                            <td>Anna</td>
                            <td>Murris</td>
                            <td>Ella</td>
                            <td><span class="stat-purple-num">{{ __('Reviewing') }}</span></td>
                            <td>
                                <button class="btn btn-green">{{ __('Approve') }}</button>
                                <button class="btn btn-red">{{ __('Reject') }}</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#A02</td>
                            <td>2026-06-11</td>
                            <td>Janis</td>
                            <td>Daisy</td>
                            <td>Ella</td>
                            <td><span class="stat-purple-num">{{ __('Reviewing') }}</span></td>
                            <td>
                                <button class="btn btn-green">{{ __('Approve') }}</button>
                                <button class="btn btn-red">{{ __('Reject') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="block-card">
                <h2>{{ __('Animal Health & Tracking') }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Animal') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Species') }}</th>
                            <th>{{ __('Health Status') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Riga</td>
                            <td>Buddy</td>
                            <td>Dog</td>
                            <td>Healthy & Vaccinated</td>
                            <td>#L01</td>
                            <td>
                                <button class="btn btn-blue">{{ __('Edit') }}</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rezekne</td>
                            <td>Luna</td>
                            <td>Cat</td>
                            <td>Needs Medical Treatment</td>
                            <td>#L01</td>
                            <td>
                                <button class="btn btn-blue">{{ __('Edit') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>