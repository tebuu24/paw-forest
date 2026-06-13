<?php
use function Livewire\Volt\{state};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Forest - Profile</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <a href="/">Home</a> <span>|</span>
                <a href="/gallery">Gallery</a> <span>|</span>
                <a href="/donations">Donate</a> <span>|</span>
                <a href="/profile"><b>Profile</b></a> <span>|</span>
                <a href="/login">Sign out</a> <span>|</span>
                
                <select class="lang-select">
                    <option value="en" selected>🌐 EN</option>
                    <option value="lv">🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container profile-layout">
        
        <div class="profile-left-column">
            
            <div class="block-card profile-info-card">
                <h1>User Profile</h1>
                <br>
                <form action="#">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" value="Alice Smith">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" value="alice_smith">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="alice.smith@example.com">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" value="Meowtown street 5a, Meowville">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-blue profile-update-btn">Update Information</button>
                </form>
            </div>

            <div class="block-card profile-security-card">
                <h2>Security Settings</h2>
                <br>
                <form action="#" class="security-form">
                    <h3>Change Password</h3>
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-blue">Change Password</button>
                    </div>
                </form>
                
                <hr class="security-divider">

                <form action="#" class="security-form">
                    <h3 class="danger-title">Delete Account</h3>
                    <p class="danger-text">Warning: This action is permanent and cannot be undone.</p>
                    <div class="form-group">
                        <label>Confirm with Password</label>
                        <input type="password" placeholder="Enter your password to confirm" required>
                    </div>
                    <button type="submit" class="btn btn-red">Permanently Delete Account</button>
                </form>
            </div>
        </div>

        <div class="block-card profile-history-card">
            <h2>My Adoption Applications</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Animal</th>
                        <th>Comment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12.05.2026</td>
                        <td>Bella(Rabbit)</td>
                        <td>Looking for a friendly pet.</td>
                        <td><span class="stat-green-num">Approved</span></td>
                    </tr>
                </tbody>
            </table>

            <br><br>
            <h2>My Scheduled Visits</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>location</th>
                        <th>Animal</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>15.06.2026</td>
                        <td>Rīga</td>
                        <td>Bella(Rabbit)</td>
                        <td>Want to meet the bunny before adopting.</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>