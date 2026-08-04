<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Name — Portfolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/portfolio.css'])
</head>
<body>

  <div class="blob one"></div>
  <div class="blob two"></div>
  <div class="blob three"></div>

  <header>
    <nav>
      <div class="nav-mark">YN.</div>
      <ul class="nav-links">
        <li><a href="#work">Work</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-copy">
      <span class="eyebrow">Design & Art Direction</span>
      <h1>Hi, I'm<br><span class="highlight">Your Name</span></h1>
      <p class="tagline">I design brand systems, digital products, and the odd bit of chaos in between. Based somewhere, working everywhere.</p>
      <div class="cta-row">
        <a href="#work" class="btn btn-primary">See the work</a>
        <a href="#contact" class="btn btn-ghost">Get in touch</a>
      </div>
    </div>

    <div class="hero-photo">
      <div class="photo-ring"></div>
      <div class="photo-frame">
        {{-- Drop your photo in public/images and update the filename below --}}
        <img src="{{ asset('images/picture.jpg') }}" alt="Portrait of Your Name" onerror="this.removeAttribute('src')">
        <!-- <div class="photo-placeholder">Your photo<br>goes here</div> -->
      </div>
    </div>
  </section>

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

  <footer id="contact">
    <div>
      <h2>Let's work together.</h2>
      <p>hello@yourname.com</p>
    </div>
    <div class="socials">
      <a href="#">Instagram</a>
      <a href="#">Dribbble</a>
      <a href="#">LinkedIn</a>
    </div>
  </footer>

</body>
</html>