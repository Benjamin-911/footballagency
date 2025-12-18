<?php
require_once __DIR__ . '/backend/session.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About & Services - Football Agency Sierra Leone</title>
  <link rel="stylesheet" href="./globals.css" />
  <meta name="description" content="About our agency and the services we offer to footballers from Sierra Leone." />
  <meta name="keywords" content="football services, player representation, Sierra Leone football, career management, international transfers" />
  <meta name="author" content="Football Agency Sierra Leone" />
  <meta name="robots" content="index, follow" />
  <meta property="og:title" content="Services - Football Agency Sierra Leone" />
  <meta property="og:description" content="Professional football services for Sierra Leonean players including representation, transfers, and career management." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://footballagentsl.com/about.php" />
  <meta property="og:image" content="./african_youth_football.jpg" />
  <link rel="canonical" href="https://footballagentsl.com/about.php" />
  <style> .hero{min-height:420px;} </style>
</head>
<body>
  <header class="header">
    <div class="container navbar">
      <a class="brand" href="index.php" aria-label="Football Agency Sierra Leone">
        <div class="logo" style="display: flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
          <img src="./images/logo.jpg" alt="Football Agency Sierra Leone Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div>
          <p class="brand-title">Football Agency <span class="flag-pill" aria-hidden="true"></span></p>
          <p class="brand-sub">Sierra Leone</p>
        </div>
      </a>
      <nav class="nav" aria-label="Primary">
        <a href="index.php">Home</a>
        <a class="active" href="about.php">Services</a>
        <a href="contact.php">Contact</a>
        <?php if (is_admin()): ?>
        <a href="register.php">Register</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero" style="background-image:url('./images/african_youth_football.jpg'); background-size:cover; background-position:center;">
      <div class="container">
        <h1 class="fade-up">Our Vision & Mission</h1>
        <p class="fade-up delay-1">Cultivating Sierra Leone's football excellence through innovative mentorship since 2015.</p>
      </div>
    </section>

    <section class="section" style="position: relative; overflow: hidden;">
      <div style="position: absolute; top: 0; right: 0; width: 300px; height: 100%; background: linear-gradient(-45deg, rgba(34,197,94,0.1), transparent); transform: skewX(15deg);"></div>
      <div class="container" style="position: relative; z-index: 2;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; min-height: 70vh;">
          <div class="fade-up" style="position: relative;">
            <div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); padding: 50px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); transform: rotate(-2deg);">
              <h2 style="font-size: 2.5rem; margin-bottom: 30px; color: #1e293b; position: relative;">
                Who We Are
                <div style="position: absolute; bottom: -8px; left: 0; width: 60px; height: 4px; background: linear-gradient(90deg, #22c55e, #2563eb); border-radius: 2px;"></div>
              </h2>
              <div>
                <p style="font-size: 1.1rem; line-height: 1.7; color: #475569; margin-bottom: 20px;">Football Agency Sierra Leone stands as a beacon of excellence, transforming raw potential into global football legends through visionary leadership and unwavering commitment.</p>
                <p style="font-size: 1.1rem; line-height: 1.7; color: #475569; margin-bottom: 20px;">Our distinguished team comprises seasoned FIFA-certified professionals, legendary former athletes, and strategic advisors who masterfully navigate the intricate world of modern football.</p>
                <p style="font-size: 1.1rem; line-height: 1.7; color: #475569;">We champion the philosophy of holistic development, guiding emerging talents from humble beginnings to the pinnacle of professional achievement with personalized excellence.</p>
              </div>
            </div>
          </div>
          <div class="scale-in" style="position: relative;">
            <div style="transform: rotate(3deg); box-shadow: 0 25px 50px rgba(0,0,0,0.2); border-radius: 20px; overflow: hidden;">
              <div class="image-skeleton" id="about-image-skeleton"></div>
              <img alt="African Football Players - Teamwork and Support" src="./images/b7d8900163bb6b3517bcfe0c32208475.jpg" style="width: 100%; height: auto; display: none;" id="about-image" onload="hideSkeleton('about-image-skeleton', 'about-image')" />
            </div>
            <div style="position: absolute; bottom: -20px; right: -20px; background: linear-gradient(135deg, #22c55e, #16a34a); color: white; padding: 15px 25px; border-radius: 15px; font-weight: bold; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(34,197,94,0.3);">
              ⚽ Since 2015
            </div>
        </div>
        </div>
      </div>
    </section>

    <section class="section muted">
      <div class="container">
        <h2>Our Foundational Pillars</h2>
        <p class="lead">The unwavering principles that shape our every endeavor and define our legacy.</p>
        <div class="grid cols-3">
          <article class="card center fade-up"><div class="content"><div class="icon-box"><span class="emoji">🛡️</span></div><h3>Unshakeable Honor</h3><p>We conduct ourselves with unyielding moral excellence and principled leadership in every interaction.</p></div></article>
          <article class="card center fade-up delay-1"><div class="content"><div class="icon-box"><span class="emoji">🤝</span></div><h3>Authentic Partnership</h3><p>Building genuine connections through crystal-clear communication and trust-based relationships.</p></div></article>
          <article class="card center fade-up delay-2"><div class="content"><div class="icon-box"><span class="emoji">🏅</span></div><h3>Relentless Pursuit</h3><p>Dedicated to orchestrating extraordinary achievements that exceed all expectations for our champions.</p></div></article>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <h2>Our Signature Offerings</h2>
        <p class="lead">Revolutionary solutions that redefine every dimension of a footballer's journey to greatness.</p>
        <div class="grid cols-2">
          <article class="card fade-up"><div class="content"><div class="icon-box"><span class="emoji">👥</span></div><h3>Champion Advocacy</h3><p>Comprehensive guardianship orchestrating every facet of your legendary career.</p><ul><li>Strategic negotiations</li><li>Global transfer facilitation</li><li>Destiny planning</li><li>Legal guardianship</li></ul></div></article>
          <article class="card fade-up delay-1"><div class="content"><div class="icon-box"><span class="emoji">🌐</span></div><h3>Worldwide Connections</h3><p>Forging pathways to elite clubs and prestigious academies across the globe.</p><ul><li>European premier leagues</li><li>Asian emerging markets</li><li>African championship circuits</li><li>Americas opportunities</li></ul></div></article>
          <article class="card fade-up delay-2"><div class="content"><div class="icon-box"><span class="emoji">📈</span></div><h3>Excellence Cultivation</h3><p>Revolutionary strategies designed to unlock unlimited potential and enduring success.</p><ul><li>Talent evaluation</li><li>Elite training regimens</li><li>Performance analytics</li><li>Media mastery</li></ul></div></article>
          <article class="card fade-up delay-3"><div class="content"><div class="icon-box"><span class="emoji">📃</span></div><h3>Strategic Guardianship</h3><p>Masterful guidance on contractual, financial, and legal complexities.</p><ul><li>Contract optimization</li><li>Wealth management</li><li>Compliance excellence</li><li>Protection coverage</li></ul></div></article>
        </div>
      </div>
    </section>

    <section class="band">
      <div class="container grid cols-4" style="text-align:center;">
        <div class="fade-up"><div class="pulse" style="font-size:44px; font-weight:700;">50+</div><p class="m-0" style="color:#e2e8f0;">Active Players</p></div>
        <div class="fade-up delay-1"><div class="pulse" style="font-size:44px; font-weight:700;">15</div><p class="m-0" style="color:#e2e8f0;">Countries</p></div>
        <div class="fade-up delay-2"><div class="pulse" style="font-size:44px; font-weight:700;">€5M+</div><p class="m-0" style="color:#e2e8f0;">Contracts Negotiated</p></div>
        <div class="fade-up delay-3"><div class="pulse" style="font-size:44px; font-weight:700;">8+</div><p class="m-0" style="color:#e2e8f0;">Years Experience</p></div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="grid cols-3">
        <div>
          <div class="brand" style="margin-bottom:12px;">
            <div class="logo" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
              <img src="./images/logo.jpg" alt="Football Agency Sierra Leone Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
            </div>
            <div>
              <h3 class="m-0">Football Agency</h3>
              <p class="m-0" style="font-size:12px; color:#94a3b8;">Sierra Leone</p>
            </div>
          </div>
          <p>Connecting talented Sierra Leonean footballers with international opportunities and managing professional careers.</p>
        </div>
        <div>
          <h3>Contact Us</h3>
          <p>15 Wilkinson Road, Freetown<br/>Sierra Leone</p>
          <p>+232 76 123 496</p>
          <p>info@footballagentsl.com</p>
        </div>
        <div>
          <h3>Follow Us</h3>
          <div class="socials">
            <a href="#" aria-label="Facebook">f</a>
            <a href="#" aria-label="Twitter">t</a>
            <a href="#" aria-label="Instagram">i</a>
            <a href="#" aria-label="LinkedIn">in</a>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright">© <span id="year"></span> Football Agency Sierra Leone. All rights reserved.</div>
  </footer>
  <script>
    // Skeleton loading functionality
    function hideSkeleton(skeletonId, imageId) {
      const skeleton = document.getElementById(skeletonId);
      const image = document.getElementById(imageId);
      
      if (skeleton && image) {
        skeleton.style.display = 'none';
        image.style.display = 'block';
        image.style.opacity = '0';
        image.style.transition = 'opacity 0.5s ease-in-out';
        
        setTimeout(() => {
          image.style.opacity = '1';
        }, 100);
      }
    }
    
    // Preload images for better performance
    const images = [
      './images/b7d8900163bb6b3517bcfe0c32208475.jpg',
      './images/african_youth_football.jpg'
    ];
    
    images.forEach(src => {
      const img = new Image();
      img.src = src;
    });
  </script>
</body>
</html>

