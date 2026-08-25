<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Victor James M. Irinco — Portfolio</title>
    
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
            <div class="nav-mark"><a href="{{ route('home') }}" style="text-decoration:none; color:inherit;">Victor James M. Irinco.</a></div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('work') }}">Work</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @if (($section ?? '') == 'home')
        <!-- Hero Section -->
        <section class="hero" id="home">
            <div class="hero-copy">
                <span class="eyebrow">BSIT Student · Web Developer</span>
                <h1>Hi, I'm<br><span class="highlight">Victor James</span></h1>
                <p class="tagline">3rd-year BSIT student at Cristal e-College, building web applications with Laravel, PHP, and modern front-end tools. Based in Tawala, Panglao, Bohol.</p>
                <div class="cta-row">
                    <a href="{{ route('work') }}" class="btn btn-primary">See the work</a>
                    <a href="{{ route('contact') }}" class="btn btn-ghost">Get in touch</a>
                </div>
            </div>

            <div class="hero-photo">
                <div class="photo-ring"></div>
                <div class="photo-frame">
                    <img src="{{ asset('images/picture.jpg') }}" alt="Portrait of Victor James M. Irinco" onerror="this.removeAttribute('src')">
                    <div class="photo-placeholder">Your photo<br>goes here</div>
                </div>
            </div>
        </section>

        <!-- Marquee Banner -->
        <div class="marquee-wrap">
            <div class="marquee">
                <span>Laravel</span><span class="dot">•</span>
                <span>PHP</span><span class="dot">•</span>
                <span>HTML / CSS</span><span class="dot">•</span>
                <span>JavaScript</span><span class="dot">•</span>
                <span>Web Development</span><span class="dot">•</span>
                <span>Laravel</span><span class="dot">•</span>
                <span>PHP</span><span class="dot">•</span>
                <span>HTML / CSS</span><span class="dot">•</span>
                <span>JavaScript</span><span class="dot">•</span>
                <span>Web Development</span><span class="dot">•</span>
            </div>
        </div>
        @endif

        @if (($section ?? '') == 'work')
        <!-- Work Grid Section -->
        <section class="work" id="work">
            <div class="section-head">
                <h2>Selected work</h2>
                <p>Projects I've built and continue to improve as a BSIT student.</p>
            </div>
            <div class="grid">
                <a href="https://github.com/irincovictor-cmd/MyfirstApp" target="_blank" rel="noopener" class="card c1">
                    <span class="num">01</span>
                    <h3>MyfirstApp</h3>
                    <p>Laravel web app with portfolio, student form, and a working calculator (add, subtract, multiply, divide).</p>
                </a>
                <a href="{{ route('operator.index') }}" class="card c2">
                    <span class="num">02</span>
                    <h3>Simple Calculator</h3>
                    <p>Interactive calculator built with Laravel routing, controllers, and Blade views.</p>
                </a>
                <a href="{{ route('student.index') }}" class="card c3">
                    <span class="num">03</span>
                    <h3>Student Form</h3>
                    <p>Basic student information form using Laravel controllers and Blade templating.</p>
                </a>
                <a href="https://github.com/irincovictor-cmd" target="_blank" rel="noopener" class="card c4">
                    <span class="num">04</span>
                    <h3>GitHub Profile</h3>
                    <p>More projects and code on my GitHub — irincovictor-cmd.</p>
                </a>
            </div>
        </section>
        @endif

        @if (($section ?? '') == 'about')
        <!-- About Section -->
        <section class="about-section" id="about">
            <div class="section-head">
                <h2>About Me</h2>
                <p>A short introduction to who I am and what I'm studying.</p>
            </div>

            <div class="about-grid">
                <div class="about-bio">
                    <p class="lead">
                        I’m Victor James M. Irinco, a 3rd-year BSIT student at Cristal e-College in Tawala, Panglao, Bohol.
                    </p>
                    <p>
                        I’m learning web development with a focus on Laravel, PHP, HTML, CSS, and JavaScript. I enjoy building practical applications — from simple forms and calculators to full portfolio sites — and continuously improving my skills through real projects.
                    </p>

                    <div class="about-stats">
                        <div class="stat-card">
                            <span class="stat-number">BSIT</span>
                            <span class="stat-label">3rd Year Student</span>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">CEC</span>
                            <span class="stat-label">Cristal e-College</span>
                        </div>
                    </div>
                </div>

                <div class="about-skills">
                    <h3>Core Skills & Tools</h3>
                    <ul class="skills-list">
                        <li><span>Laravel & PHP</span></li>
                        <li><span>HTML5 / CSS3</span></li>
                        <li><span>JavaScript</span></li>
                        <li><span>Blade Templating</span></li>
                        <li><span>Git & GitHub</span></li>
                        <li><span>Responsive Web Design</span></li>
                    </ul>
                </div>
            </div>
        </section>
        @endif

        @if (($section ?? '') == 'contact')
        <!-- Dedicated Contact Section -->
        <section class="contact-section" style="max-width: 1180px; margin: 0 auto; padding: 6rem 1.5rem;">
            <div class="section-head">
                <h2>Get In Touch</h2>
                <p>Feel free to reach out for collaborations, project inquiries, or just a friendly chat.</p>
            </div>
            <div style="background: var(--violet-soft); border: 1px solid var(--line); border-radius: 16px; padding: 2.5rem; margin-top: 2rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--paper);">Direct Email</h3>
                <p style="color: var(--paper-dim); margin-bottom: 1.5rem;">Irinco.victor@cec.edu.ph</p>
                <a href="mailto:Irinco.victor@cec.edu.ph" class="btn btn-primary">Send Email</a>
            </div>
        </section>
        @endif
    </main>

    <!-- Footer / Contact -->
    <footer id="contact">
        <div>
            <h2>Let's work together.</h2>
            <p>Irinco.victor@cec.edu.ph</p>
            <p style="margin-top: 0.5rem; opacity: 0.8;">Tawala, Panglao, Bohol</p>
        </div>
        <div class="socials">
            <a href="https://www.instagram.com/irincovictorjames?igsh=MTNqaHV3ZXE2c28xcQ==" target="_blank" rel="noopener">Instagram</a>
            <a href="https://www.facebook.com/share/1HpXzsaixM/" target="_blank" rel="noopener">Facebook</a>
            <a href="https://www.linkedin.com/in/victorjames-irinco-84696936b/" target="_blank" rel="noopener">LinkedIn</a>
            <a href="https://github.com/irincovictor-cmd" target="_blank" rel="noopener">GitHub</a>
        </div>
    </footer>

</body>
</html>
