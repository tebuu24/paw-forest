<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Forest - Animal Profile</title>
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
                <a href="/gallery"><b>Gallery</b></a> <span>|</span>
                <a href="/donations">Donate</a> <span>|</span>
                <a href="/profile">Profile</a> <span>|</span>
                <a href="/login">Log in</a> <span>|</span>
                
                <select class="lang-select">
                    <option value="en" selected>🌐 EN</option>
                    <option value="lv">🌐 LV</option>
                </select>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="profile-view-layout block-card">
            
            <div class="profile-view-img">
                <div class="img-placeholder animal-big-placeholder"></div>
            </div>
            
            <div class="profile-view-data">
                <h1>Buddy</h1>
                <p><b>Species:</b> Dog</p>
                <p><b>Breed:</b> Golden Retriever</p>
                <p><b>Age:</b> 3 years</p>
                <p><b>Gender:</b> Female</p>
                <p><b>Health Status:</b> Healthy & Vaccinated</p>
                <p><b>Shelter Location ID:</b> #L01</p>
                <p><b>Date Added to Shelter:</b> 2025-04-10</p>
                
                <h2 class="profile-section-title">Description / Medication Notes:</h2>
                <p>Buddy is a friendly, active retriever. Currently receives regular flea prevention and checks.</p>
                
                <div class="profile-action-buttons">
                    <a href="/apply-adoption" class="btn btn-blue">Apply for Adoption</a>
                    <a href="/apply-visitation" class="btn btn-green">Apply for Visitation</a>
                </div>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>

</body>
</html>