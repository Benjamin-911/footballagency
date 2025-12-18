<?php
require_once __DIR__ . '/backend/session.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact - Football Agency Sierra Leone</title>
  <link rel="stylesheet" href="./globals.css" />
  <meta name="description" content="Get in touch with Football Agency Sierra Leone for representation and inquiries." />
  <meta name="keywords" content="contact football agent, Sierra Leone football contact, player representation inquiry, football career consultation" />
  <meta name="author" content="Football Agency Sierra Leone" />
  <meta name="robots" content="index, follow" />
  <meta property="og:title" content="Contact - Football Agency Sierra Leone" />
  <meta property="og:description" content="Contact Football Agency Sierra Leone for professional football representation and career guidance." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://footballagentsl.com/contact.php" />
  <meta property="og:image" content="./african_football_match.jpg" />
  <link rel="canonical" href="https://footballagentsl.com/contact.php" />
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
        <a href="about.php">Services</a>
        <a class="active" href="contact.php">Contact</a>
        <?php if (is_admin()): ?>
        <a href="register.php">Register</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero" style="background-image:url('./images/african_football_match.jpg'); background-size:cover; background-position:center;">
      <div class="container">
        <h1 class="fade-up">Begin Your Journey</h1>
        <p class="fade-up delay-1">Ready to transform your football dreams into reality? Let's start your legendary story together.</p>
      </div>
    </section>

    <section class="section muted" style="position: relative; overflow: hidden;">
      <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, transparent 0%, rgba(37,99,235,0.05) 50%, transparent 100%); transform: skewY(1deg);"></div>
      <div class="container" style="position: relative; z-index: 2;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-top: 40px;">
          <article class="card center fade-up" style="transform: rotate(-2deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 8px 20px rgba(34,197,94,0.3);"><span class="emoji">📍</span></div>
              <h3 style="font-size: 1.4rem; margin-bottom: 16px; color: #1e293b;">Our Headquarters</h3>
              <p style="color: #64748b; line-height: 1.6;">15 Wilkinson Road<br/>Freetown, Sierra Leone</p>
            </div>
          </article>
          <article class="card center fade-up delay-1" style="transform: rotate(1deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-top: 20px;">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 8px 20px rgba(37,99,235,0.3);"><span class="emoji">📞</span></div>
              <h3 style="font-size: 1.4rem; margin-bottom: 16px; color: #1e293b;">Direct Connection</h3>
              <p style="color: #64748b; line-height: 1.6;">+232 76 123 496<br/>+232 78 987 684</p>
            </div>
          </article>
          <article class="card center fade-up delay-2" style="transform: rotate(-1.5deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-top: 40px;">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #dc2626, #b91c1c); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 8px 20px rgba(220,38,38,0.3);"><span class="emoji">✉️</span></div>
              <h3 style="font-size: 1.4rem; margin-bottom: 16px; color: #1e293b;">Digital Gateway</h3>
              <p style="color: #64748b; line-height: 1.6;">info@footballagentsl.com<br/>careers@footballagentsl.com</p>
            </div>
          </article>
          <article class="card center fade-up delay-3" style="transform: rotate(2deg); transition: all 0.3s ease; border: none; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-top: 10px;">
            <div class="content" style="padding: 40px 30px; text-align: center;">
              <div class="icon-box" style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #7c3aed, #6d28d9); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 8px 20px rgba(124,58,237,0.3);"><span class="emoji">⏰</span></div>
              <h3 style="font-size: 1.4rem; margin-bottom: 16px; color: #1e293b;">Available Hours</h3>
              <p style="color: #64748b; line-height: 1.6;">Mon-Fri: 9:00-18:00<br/>Sat: 10:00-14:00</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="section" style="position: relative; overflow: hidden;">
      <div style="position: absolute; top: 0; right: 0; width: 200px; height: 100%; background: linear-gradient(-45deg, rgba(34,197,94,0.1), transparent); transform: skewX(-10deg);"></div>
      <div class="container" style="position: relative; z-index: 2;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
          <div class="form-card fade-up" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); padding: 50px; border-radius: 25px; box-shadow: 0 25px 50px rgba(0,0,0,0.1); transform: rotate(-1deg);">
          <div class="content">
                <h2 class="m-0" style="font-size: 2.2rem; margin-bottom: 30px; color: #1e293b; position: relative;">
                Share Your Vision
                <div style="position: absolute; bottom: -8px; left: 0; width: 80px; height: 4px; background: linear-gradient(90deg, #22c55e, #2563eb); border-radius: 2px;"></div>
              </h2>
              <form class="mt-12" id="contactForm" style="transform: rotate(0.5deg);">
              <div style="margin-bottom:16px;">
                <label class="label" for="name">Full Name *</label>
                <input class="input" id="name" name="name" type="text" placeholder="Bernard Gamanga" required />
                <div class="error-message" id="name-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 4px; display: none;"></div>
              </div>
              <div style="margin-bottom:16px;">
                <label class="label" for="email">Email Address *</label>
                <input class="input" id="email" name="email" type="email" placeholder="Bernard@example.com" required />
                <div class="error-message" id="email-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 4px; display: none;"></div>
              </div>
              <div style="margin-bottom:16px;">
                <label class="label" for="phone">Phone Number</label>
                <input class="input" id="phone" name="phone" type="tel" placeholder="+232 76 123 496" />
                <div class="error-message" id="phone-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 4px; display: none;"></div>
              </div>
              <div style="margin-bottom:16px;">
                <label class="label" for="subject">Subject *</label>
                <select class="select" id="subject" name="subject" required>
                  <option value="" disabled selected>Select a subject</option>
                  <option value="representation">Player Representation</option>
                  <option value="transfer">Transfer Inquiry</option>
                  <option value="scouting">Scouting Services</option>
                  <option value="partnership">Partnership Opportunity</option>
                  <option value="general">General Inquiry</option>
                </select>
                <div class="error-message" id="subject-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 4px; display: none;"></div>
              </div>
              <div style="margin-bottom:16px;">
                <label class="label" for="message">Message *</label>
                <textarea class="textarea" id="message" name="message" placeholder="Tell us more about your inquiry..." rows="6" required></textarea>
                <div class="error-message" id="message-error" style="color: #dc2626; font-size: 0.875rem; margin-top: 4px; display: none;"></div>
              </div>
              <button type="submit" class="btn primary glow" style="width:100%;">Send Message →</button>
            </form>
          </div>
        </div>
        <div>
          <div class="card scale-in" style="height:400px; overflow:hidden;">
            <iframe title="Office Location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63249.85944234374!2d-13.2344164!3d8.4843448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf04bece7498f0b1%3A0x3f1f1b7f8d0f1d0f!2sFreetown%2C%20Sierra%20Leone!5e0!3m2!1sen!2s!4v1234567890" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
          <div class="card" style="margin-top:24px; background:linear-gradient(135deg, var(--primary), var(--accent)); color:white;">
            <div class="content">
              <h3 class="m-0">Why We Stand Apart?</h3>
              <ul>
                <li>Elite FIFA-certified professionals with legendary achievements</li>
                <li>Masterful navigation of global and local football landscapes</li>
                <li>Bespoke mentorship tailored to each champion's unique journey</li>
                <li>Unwavering commitment to integrity and excellence</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section muted">
      <div class="container">
        <h2 class="center">Common Inquiries</h2>
        <div class="grid cols-2">
          <article class="card"><div class="content"><h3>How do I begin my journey with your agency?</h3><p>Reach out through our contact form or direct communication channels. We'll evaluate your potential, schedule a consultation, and design a personalized path to elevate your football career.</p></div></article>
          <article class="card"><div class="content"><h3>What investment is required for your services?</h3><p>Our fee structure reflects our commitment to excellence and is designed for mutual success. We operate on a performance-based model that aligns with your achievements and career milestones.</p></div></article>
          <article class="card"><div class="content"><h3>Do you nurture emerging talent?</h3><p>Absolutely! We specialize in identifying and developing young prodigies, placing them in elite academies across Europe, Africa, and beyond. Early mentorship is the foundation of legendary careers.</p></div></article>
        </div>
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
    // Form validation with visual feedback
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Clear previous errors
      clearErrors();
      
      let isValid = true;
      
      // Validate name
      const name = document.getElementById('name').value.trim();
      if (name.length < 2) {
        showError('name-error', 'Name must be at least 2 characters long');
        isValid = false;
      }
      
      // Validate email
      const email = document.getElementById('email').value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        showError('email-error', 'Please enter a valid email address');
        isValid = false;
      }
      
      // Validate phone (if provided)
      const phone = document.getElementById('phone').value.trim();
      if (phone && !/^[\+]?[0-9\s\-\(\)]{10,}$/.test(phone)) {
        showError('phone-error', 'Please enter a valid phone number');
        isValid = false;
      }
      
      // Validate subject
      const subject = document.getElementById('subject').value;
      if (!subject) {
        showError('subject-error', 'Please select a subject');
        isValid = false;
      }
      
      // Validate message
      const message = document.getElementById('message').value.trim();
      if (message.length < 10) {
        showError('message-error', 'Message must be at least 10 characters long');
        isValid = false;
      }
      
      if (isValid) {
        // Show success message
        showSuccessMessage();
        this.reset();
      }
    });
    
    function showError(errorId, message) {
      const errorElement = document.getElementById(errorId);
      errorElement.textContent = message;
      errorElement.style.display = 'block';
      
      // Add error styling to input
      const input = errorElement.previousElementSibling;
      input.style.borderColor = '#dc2626';
      input.style.boxShadow = '0 0 0 4px rgba(220, 38, 38, 0.15)';
    }
    
    function clearErrors() {
      const errorElements = document.querySelectorAll('.error-message');
      errorElements.forEach(error => {
        error.style.display = 'none';
        error.textContent = '';
      });
      
      // Reset input styling
      const inputs = document.querySelectorAll('.input, .select, .textarea');
      inputs.forEach(input => {
        input.style.borderColor = '';
        input.style.boxShadow = '';
      });
    }
    
    function showSuccessMessage() {
      const button = document.querySelector('button[type="submit"]');
      const originalText = button.textContent;
      button.textContent = 'Message Sent! ✓';
      button.style.background = '#16a34a';
      
      setTimeout(() => {
        button.textContent = originalText;
        button.style.background = '';
      }, 3000);
    }
    
    // Real-time validation
    document.getElementById('name').addEventListener('blur', function() {
      if (this.value.trim().length < 2) {
        showError('name-error', 'Name must be at least 2 characters long');
      } else {
        clearFieldError('name-error');
      }
    });
    
    document.getElementById('email').addEventListener('blur', function() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.value.trim())) {
        showError('email-error', 'Please enter a valid email address');
      } else {
        clearFieldError('email-error');
      }
    });
    
    function clearFieldError(errorId) {
      const errorElement = document.getElementById(errorId);
      errorElement.style.display = 'none';
      const input = errorElement.previousElementSibling;
      input.style.borderColor = '';
      input.style.boxShadow = '';
    }
  </script>
</body>
</html>

