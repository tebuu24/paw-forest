<?php
use function Livewire\Volt\{state};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Forest</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <div class="nav-inner">
            <div class="logo-area">
                <h2>🏠 Paw Forest</h2>
            </div>
            <nav class="pub-nav">
                <a href="/"><b>Home</b></a> <span>|</span>
                <a href="/gallery">Gallery</a> <span>|</span>
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

        <section class="block-card hero-section">
            <p class="hero-tagline">Open for Adoption · Est. 2020</p>
            <h1 class="hero-title">Find Your Perfect Fluffy Friend</h1>
            <p class="hero-text">
                Every resident of our shelter is waiting for a loving home. 
                Get to know them and give someone a second chance!
            </p>
            <div class="hero-buttons">
                <a href="#gallery" class="btn btn-blue">Meet the Animals</a>
            </div>
        </section>

        <div class="stats-row">
            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">Animals Adopted</div>
                <div class="num stat-green-num">124</div>
            </div>

            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">Animals Needing a Home</div>
                <div class="num stat-red-num">45</div>
            </div>

            <div class="admin-stat-card block-card">
                <div class="stat-icon-label">Latest Donations</div>
                <div class="num stat-purple-num">$2,500</div>
            </div>
        </div>
        <h2 id="gallery">Recently added</h2>
        <section class="gallery-grid">
            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Buddy</h2>
                    <p>Dog, 3 years, Riga</p>
                    <a href="/animal-profile" class="btn btn-green">View Profile</a>
                </div>
            </div>

            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Whiskers</h2>
                    <p>Cat, 1 year, Rezekne</p>
                    <a href="/animal-profile" class="btn btn-green">View Profile</a>
                </div>
            </div>

            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Rocky</h2>
                    <p>Rabbit, 6 months, Ventspils</p>
                    <a href="/animal-profile" class="btn btn-green">View Profile</a>
                </div>
            </div>

            <div class="animal-card block-card">
                <div class="img-placeholder"></div>
                <div class="card-info">
                    <h2>Goldie</h2>
                    <p>Fish, 2 months, Riga</p>
                    <a href="/animal-profile" class="btn btn-green">View Profile</a>
                </div>
            </div>
        </section>

        <section class="block-card animal-fact-section">
            <div class="fact-content">
                <span class="fact-pretitle">💡 Did You Know?</span>
                <h2 class="fact-title">Fun Animal Fact</h2>
                <p id="animal-fact-placeholder" class="fact-text">
                    Loading an interesting animal fact just for you...
                </p>
                <button id="next-fact-btn" class="btn btn-orange">Get Another Fact</button>
            </div>
        </section>

        <section class="block-card info-split-section">
            <div class="block-card info-visual-box">
                🏡
            </div>
            <div class="info-content-box">
                <span class="info-pretitle">About Our Shelter</span>
                <h2 class="info-title">A Safe Haven Guided by Love</h2>
                <p class="info-paragraph">
                    Paw Forest is a non-profit animal shelter dedicated to finding the right home for every animal. Our staff and volunteers provide daily care, medical support, and most importantly — endless love.
                </p>
                <p class="info-paragraph">
                    Whether you are ready to adopt, help out as a foster home, or simply support us during weekends — there is always a place for kind people here.
                </p>
            </div>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 Paw Forest</p>
    </footer>
</body>
</html>