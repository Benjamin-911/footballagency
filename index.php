<?php
require_once __DIR__ . '/backend/session.php';
require_login();
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Football Agency Sierra Leone</title>
  <link rel="stylesheet" href="./globals.css" />
  <meta name="description" content="Your gateway to professional football. Representing Sierra Leone's finest football talent on the global stage." />
  <meta name="keywords" content="football agent, Sierra Leone, football representation, player management, international transfers, African football" />
  <meta name="author" content="Football Agency Sierra Leone" />
  <meta name="robots" content="index, follow" />
  <meta property="og:title" content="Football Agency Sierra Leone - Professional Football Representation" />
  <meta property="og:description" content="Your gateway to professional football. Representing Sierra Leone's finest football talent on the global stage." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://footballagentsl.com" />
  <meta property="og:image" content="./images/kenya_ball.jpg" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Football Agency Sierra Leone" />
  <meta name="twitter:description" content="Professional football representation for Sierra Leonean players" />
  <link rel="canonical" href="https://footballagentsl.com" />
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SportsTeam",
    "name": "Football Agency Sierra Leone",
    "description": "Professional football representation agency for Sierra Leonean players",
    "url": "https://footballagentsl.com",
    "logo": "https://footballagentsl.com/logo.png",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "15 Wilkinson Road",
      "addressLocality": "Freetown",
      "addressCountry": "Sierra Leone"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+232-76-123-496",
      "contactType": "customer service",
      "email": "info@footballagentsl.com"
    },
    "sameAs": [
      "https://facebook.com/footballagentsl",
      "https://twitter.com/footballagentsl",
      "https://instagram.com/footballagentsl"
    ]
  }
  </script>
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
        <a class="active" href="index.php">Home</a>
        <a href="about.php">Services</a>
        <a href="contact.php">Contact</a>
        <?php if (is_admin()): ?>
        <a href="register.php">Register</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero" style="background: linear-gradient(135deg, #16a34a 0%, #2563eb 100%), url('./images/kenya_ball.jpg'); background-size:cover; background-position:center; background-blend-mode: overlay; position: relative; overflow: hidden;">
      <div style="position: absolute; top: 0; right: -50px; width: 200px; height: 100%; background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent); transform: skewX(-15deg);"></div>
      <div style="position: absolute; bottom: 0; left: -30px; width: 150px; height: 100%; background: linear-gradient(-45deg, rgba(34,197,94,0.2), transparent); transform: skewX(15deg);"></div>
      <div class="container" style="position: relative; z-index: 2;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 60px; align-items: center; min-height: 80vh;">
          <div>
            <h1 class="fade-up" style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 24px;">Unleashing Dreams, Building Champions</h1>
            <p class="fade-up delay-1" style="font-size: 1.25rem; margin-bottom: 40px; opacity: 0.9;">Transforming Sierra Leone's rising stars into global football legends through passion and dedication.</p>
            <div class="fade-up delay-2" style="display: flex; gap: 20px; flex-wrap: wrap;">
              <a class="btn primary" href="contact.php" style="transform: rotate(-2deg); box-shadow: 0 8px 25px rgba(0,0,0,0.3);">Get Started →</a>
              <a class="btn ghost" href="about.php" style="transform: rotate(1deg);">Learn More</a>
            </div>
          </div>
          <div class="fade-up delay-3" style="position: relative;">
            <div class="float" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; border: 1px solid rgba(255,255,255,0.2); transform: rotate(3deg);">
              <div style="text-align: center;">
                <div class="bounce" style="font-size: 3rem; margin-bottom: 16px;">⚽</div>
                <h3 style="color: white; margin-bottom: 12px;">Become a Legend</h3>
                <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem;">Join the journey from grassroots to greatness</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section muted" aria-labelledby="services-heading" style="position: relative; overflow: hidden;">
      <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(45deg, transparent 0%, rgba(34,197,94,0.05) 50%, transparent 100%); transform: skewY(-2deg);"></div>
      <div class="container" style="position: relative; z-index: 2;">
        <div style="text-align: center; margin-bottom: 60px;">
          <h2 id="services-heading" style="font-size: 2.5rem; margin-bottom: 20px; position: relative;">
            <span style="position: relative; z-index: 2;">Our Services</span>
            <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: linear-gradient(90deg, #22c55e, #2563eb); border-radius: 2px;"></div>
          </h2>
          <p class="lead" style="max-width: 600px; margin: 0 auto;">Bespoke mentorship and strategic guidance that transforms raw talent into professional excellence.</p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 60px;">
          <article class="card fade-up" style="transform: rotate(-1deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 80px; height: 80px; margin: 0 auto 24px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 8px 20px rgba(34,197,94,0.3);"><span class="emoji">🎯</span></div>
              <h3 style="font-size: 1.5rem; margin-bottom: 16px; color: #1e293b;">Talent Cultivation</h3>
              <p style="color: #64748b; line-height: 1.6;">Nurturing exceptional athletes through every phase of their journey to stardom.</p>
            </div>
          </article>
          <article class="card fade-up delay-1" style="transform: rotate(1deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-top: 20px;">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 80px; height: 80px; margin: 0 auto 24px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 8px 20px rgba(37,99,235,0.3);"><span class="emoji">🤝</span></div>
              <h3 style="font-size: 1.5rem; margin-bottom: 16px; color: #1e293b;">Strategic Partnerships</h3>
              <p style="color: #64748b; line-height: 1.6;">Crafting mutually beneficial alliances that unlock extraordinary opportunities for our athletes.</p>
            </div>
          </article>
          <article class="card fade-up delay-2" style="transform: rotate(-0.5deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-top: 40px;">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 80px; height: 80px; margin: 0 auto 24px; background: linear-gradient(135deg, #dc2626, #b91c1c); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 8px 20px rgba(220,38,38,0.3);"><span class="emoji">🏆</span></div>
              <h3 style="font-size: 1.5rem; margin-bottom: 16px; color: #1e293b;">Diamond Discovery</h3>
              <p style="color: #64748b; line-height: 1.6;">Uncovering hidden gems and polishing future champions from Sierra Leone's grassroots.</p>
            </div>
          </article>
          <article class="card fade-up delay-3" style="transform: rotate(1.5deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-top: 10px;">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 80px; height: 80px; margin: 0 auto 24px; background: linear-gradient(135deg, #7c3aed, #6d28d9); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 8px 20px rgba(124,58,237,0.3);"><span class="emoji">🌍</span></div>
              <h3 style="font-size: 1.5rem; margin-bottom: 16px; color: #1e293b;">Global Pathways</h3>
              <p style="color: #64748b; line-height: 1.6;">Creating bridges to prestigious leagues and academies across continents.</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="section" aria-labelledby="stories-heading">
      <div class="container">
        <h2 id="stories-heading">Success Stories</h2>
        <p class="lead">Recent achievements of our represented players.</p>
        <div class="grid cols-3">
          <article class="card center scale-in">
            <div class="content">
              <div class="icon-box pulse" style="border-radius:50%; background:linear-gradient(135deg, var(--primary), var(--accent)); color:white;">M</div>
              <h3 class="m-0">Mohamed Kamara</h3>
              <p class="m-0" style="color:var(--primary);">Signed with Guinean club Horoya FC</p>
              <p class="m-0" style="color:var(--muted);">Guinea</p>
            </div>
          </article>
          <article class="card center scale-in delay-1">
            <div class="content">
              <div class="icon-box pulse" style="border-radius:50%; background:linear-gradient(135deg, var(--primary), var(--accent)); color:white;">A</div>
              <h3 class="m-0">Abdul Sesay</h3>
              <p class="m-0" style="color:var(--primary);">National Team Call-up</p>
              <p class="m-0" style="color:var(--muted);">Sierra Leone</p>
            </div>
          </article>
          <article class="card center scale-in delay-2">
            <div class="content">
              <div class="icon-box pulse" style="border-radius:50%; background:linear-gradient(135deg, var(--primary), var(--accent)); color:white;">I</div>
              <h3 class="m-0">Ibrahim Turay</h3>
              <p class="m-0" style="color:var(--primary);">Signed with BO Rangers</p>
              <p class="m-0" style="color:var(--muted);">Sierra Leone</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="band">
      <div class="container">
        <h2>Ready to Write Your Football Legacy?</h2>
        <p>Join our family of extraordinary athletes and let us craft your path to immortality.</p>
        <a class="btn" style="background:white; color: var(--primary);" href="contact.php">Contact Us Today</a>
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


</body>
</html>

