<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Victor James Irinco — Portfolio</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite CSS -->
    @vite(['resources/css/portfolio.css'])
</head>
<body>

    <!-- Ambient background blobs -->
    <div class="blob one"></div>
    <div class="blob two"></div>
    <div class="blob three"></div>

    <!-- Navigation -->
    <header>
        <nav>
            <div class="nav-mark">Victor James Irinco.</div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}#work">Work</a></li>
                <li><a href="{{ route('home') }}#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @if (($section ?? '') == 'home')
        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="hero-copy">
                <span class="eyebrow">Design & Art Direction</span>
                <h1>Hi, I'm<br><span class="highlight">Victor James</span></h1>
                <p class="tagline">I design brand systems, digital products, and the odd bit of chaos in between. Based somewhere, working everywhere.</p>
                <div class="cta-row">
                    <a href="#work" class="btn btn-primary">See the work</a>
                    <a href="#contact" class="btn btn-ghost">Get in touch</a>
                </div>
            </div>

            <div class="hero-photo">
                <div class="photo-ring"></div>
                <div class="photo-frame">
                    <img src="{{ asset('images/picture.jpg') }}" alt="Portrait of Victor James" onerror="this.removeAttribute('src')">
                    <div class="photo-placeholder">Your photo<br>goes here</div>
                </div>
            </div>
        </section>
        @endif

        <!-- Marquee Banner -->
        <div class="marquee-wrap">
            <div class="marquee">
                <span>Brand Identity</span><span class="dot">•</span>
                <span>Art Direction</span><span class="dot">•</span>
                <span>Product Design</span><span class="dot">•</span>
                <span>Motion</span><span class="dot">•</span>
                <span>Typography</span><span class="dot">•</span>
                <span>Brand Identity</span><span class="dot">•</span>
                <span>Art Direction</span><span class="dot">•</span>
                <span>Product Design</span><span class="dot">•</span>
                <span>Motion</span><span class="dot">•</span>
                <span>Typography</span><span class="dot">•</span>
            </div>
        </div>

        <!-- Work Grid Section -->
        <section class="work" id="work">
            <div class="section-head">
                <h2>Selected work</h2>
                <p>A handful of recent projects — swap these in for your real case studies.</p>
            </div>
            <div class="grid">
                <a href="#" class="card c1">
                    <span class="num">01</span>
                    <h3>Project One</h3>
                    <p>Brand identity for a fictional client</p>
                </a>
                <a href="#" class="card c2">
                    <span class="num">02</span>
                    <h3>Project Two</h3>
                    <p>Digital product design</p>
                </a>
                <a href="#" class="card c3">
                    <span class="num">03</span>
                    <h3>Project Three</h3>
                    <p>Motion & visual identity</p>
                </a>
                <a href="#" class="card c4">
                    <span class="num">04</span>
                    <h3>Project Four</h3>
                    <p>Editorial art direction</p>
                </a>
            </div>
        </section>

        <!-- About Section -->
       <!-- About Section -->
        <section class="about-section" id="about">
            <div class="section-head">
                <h2>About Me</h2>
                <p>A brief look into my background, skills, and design philosophy.</p>
            </div>

            <div class="about-grid">
                <div class="about-bio">
                    <p class="lead">
                        I’m Victor James Irinco, a multidisciplinary designer and web developer dedicated to building engaging, functional, and visually striking digital experiences.
                    </p>
                    <p>
                        My work lies at the intersection of clean modern layouts, brand identity, and front-end development. Whether it’s crafting custom design systems or developing interactive web applications, I focus on detail, usability, and creativity.
                    </p>

                    <div class="about-stats">
                        <div class="stat-card">
                            <span class="stat-number">03+</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Completed Projects</span>
                        </div>
                    </div>
                </div>

                <div class="about-skills">
                    <h3>Core Skills & Tools</h3>
                    <ul class="skills-list">
                        <li><span>UI/UX & Web Design</span></li>
                        <li><span>Brand Identity</span></li>
                        <li><span>HTML5 / CSS3 / JavaScript</span></li>
                        <li><span>Laravel & PHP</span></li>
                        <li><span>Responsive Development</span></li>
                        <li><span>Figma & Adobe Suite</span></li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer / Contact -->
    <footer id="contact">
        <div>
            <h2>Let's work together.</h2>
            <p>Irinco.victor@cec.edu.ph</p>
        </div>
        <div class="socials">
            <a href="https://www.instagram.com/irincovictorjames?igsh=MTNqaHV3ZXE2c28xcQ==" target="_blank" rel="noopener">Instagram</a>
            <a href="https://www.facebook.com/share/1HpXzsaixM/" target="_blank" rel="noopener">Facebook</a>
            <a href="https://www.linkedin.com/in/victorjames-irinco-84696936b/" target="_blank" rel="noopener">LinkedIn</a>
        </div>
    </footer>

</body>
</html>