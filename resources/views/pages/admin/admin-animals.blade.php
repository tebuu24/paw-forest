<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Animals') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="active"><a href="/admin/animals">{{ __('Animals') }}</a></li>
                    <li><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    @endif
                    
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
                    
                    @if(auth()->user()->role === 'admin')
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
            <h1>{{ __('Manage Animals Database') }}</h1>
            <br>

            <div class="block-card">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Species') }}</th>
                            <th>{{ __('Breed') }}</th>
                            <th>{{ __('Gender') }}</th>
                            <th>{{ __('Health Status') }}</th>
                            <th>{{ __('Shelter Location') }}</th>
                            <th>{{ __('Date Added') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="inline-add-row">
                            <td><span class="auto-id">{{ __('Auto') }}</span></td>
                            <td><input type="text" placeholder="{{ __('e.g. Buddy') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Dog') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Golden') }}" required></td>
                            <td>
                                <select>
                                    <option value="Male">{{ __('Male') }}</option>
                                    <option value="Female">{{ __('Female') }}</option>
                                </select>
                            </td>
                            <td><input type="text" placeholder="{{ __('e.g. Healthy') }}" required></td>
                            <td><input type="text" placeholder="{{ __('e.g. Riga') }}" required></td>
                            <td><input type="date" required></td>
                            <td>
                                <button type="submit" class="btn btn-green table-inline-btn">{{ __('Save') }}</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>#001</td>
                            <td>Buddy</td>
                            <td>Dog</td>
                            <td>Golden Retriever</td>
                            <td>Female</td>
                            <td>Healthy</td>
                            <td>Riga</td>
                            <td>2025-04-10</td>
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