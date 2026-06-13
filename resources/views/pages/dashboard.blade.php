<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li class="active"><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/admin/animals">Animals</a></li>
                    <li><a href="/admin/applications">Applications</a></li>
                    <li><a href="/admin/donations">Donations</a></li>
                    <li><a href="/admin/medicine">Medications</a></li>
                    <li><a href="/admin/users">Users</a></li>
                </ul>
            </div>
            
            <div class="admin-lang-container">
                <select class="lang-select admin-lang-select">
                    <option value="en" selected>🌐 EN</option>
                    <option value="lv">🌐 LV</option>
                </select>
            </div>

            <div>
                <a href="/login" class="btn btn-red logout-btn">Log out</a>
            </div>
        </aside>

        <main class="admin-main">
            <h1>Dashboard Overview</h1>

            <div class="stats-row">
                <div class="admin-stat-card block-card">
                    <h2>Animals Registered</h2>
                    <div class="num stat-green-num">169</div>
                </div>
                <div class="admin-stat-card block-card">
                    <h2>Pending Adoptions</h2>
                    <div class="num stat-red-num">14</div>
                </div>
                <div class="admin-stat-card block-card">
                    <h2>Total Donations Received</h2>
                    <div class="num stat-purple-num">$2,500</div>
                </div>
            </div>

            <section class="block-card">
                <h2>Recent Adoption Requests (Adoption Table)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Date</th>
                            <th>User ID</th>
                            <th>Animal ID</th>
                            <th>Employee ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#A01</td>
                            <td>2026-06-12</td>
                            <td>#U44</td>
                            <td>#001</td>
                            <td>#E12</td>
                            <td><span class="stat-purple-num">Reviewing</span></td>
                            <td>
                                <button class="btn btn-green">Approve</button>
                                <button class="btn btn-red">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#A02</td>
                            <td>2026-06-11</td>
                            <td>#U89</td>
                            <td>#003</td>
                            <td>#E12</td>
                            <td><span class="stat-purple-num">Reviewing</span></td>
                            <td>
                                <button class="btn btn-green">Approve</button>
                                <button class="btn btn-red">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="block-card">
                <h2>Animal Health & Tracking (Animal Table)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Animal ID</th>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Health Status</th>
                            <th>Location ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Buddy</td>
                            <td>Dog</td>
                            <td>Healthy & Vaccinated</td>
                            <td>#L01</td>
                            <td>
                                <button class="btn btn-blue">Edit Profile</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Luna</td>
                            <td>Cat</td>
                            <td>Needs Medical Treatment</td>
                            <td>#L01</td>
                            <td>
                                <button class="btn btn-blue">Edit Profile</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>