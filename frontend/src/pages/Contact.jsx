import { useState } from 'react';

const initialForm = {
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: ''
};

export default function Contact() {
  const [form, setForm] = useState(initialForm);
  const [errors, setErrors] = useState({});
  const [submitted, setSubmitted] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
    setErrors((prev) => ({ ...prev, [name]: undefined }));
  };

  const validate = () => {
    const nextErrors = {};

    if (!form.name || form.name.trim().length < 2) {
      nextErrors.name = 'Name must be at least 2 characters long';
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!form.email || !emailRegex.test(form.email.trim())) {
      nextErrors.email = 'Please enter a valid email address';
    }

    if (form.phone && !/^[\+]?[0-9\s\-\(\)]{10,}$/.test(form.phone.trim())) {
      nextErrors.phone = 'Please enter a valid phone number';
    }

    if (!form.subject) {
      nextErrors.subject = 'Please select a subject';
    }

    if (!form.message || form.message.trim().length < 10) {
      nextErrors.message = 'Message must be at least 10 characters long';
    }

    return nextErrors;
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const nextErrors = validate();
    if (Object.keys(nextErrors).length > 0) {
      setErrors(nextErrors);
      return;
    }

    // In a real app, you would POST this to a backend endpoint here.
    // For now we just simulate a successful submission.
    setSubmitted(true);
    setForm(initialForm);
  };

  return (
    <>
      <section className="hero contact-hero">
        <div className="hero-overlay" />
        <div className="container hero-content">
          <div className="hero-text">
            <h1>Begin Your Journey</h1>
            <p>
              Ready to transform your football dreams into reality? Let&apos;s start your
              legendary story together.
            </p>
          </div>
        </div>
      </section>

      <section className="section muted">
        <div className="container contact-grid">
          <div className="contact-info-grid">
            <article className="card center">
              <div className="content">
                <div className="icon-box">
                  <span className="emoji">📍</span>
                </div>
                <h3>Our Headquarters</h3>
                <p>
                  15 Wilkinson Road
                  <br />
                  Freetown, Sierra Leone
                </p>
              </div>
            </article>
            <article className="card center">
              <div className="content">
                <div className="icon-box">
                  <span className="emoji">📞</span>
                </div>
                <h3>Direct Connection</h3>
                <p>
                  +232 76 123 496
                  <br />
                  +232 78 987 684
                </p>
              </div>
            </article>
            <article className="card center">
              <div className="content">
                <div className="icon-box">
                  <span className="emoji">✉️</span>
                </div>
                <h3>Digital Gateway</h3>
                <p>
                  info@footballagentsl.com
                  <br />
                  careers@footballagentsl.com
                </p>
              </div>
            </article>
            <article className="card center">
              <div className="content">
                <div className="icon-box">
                  <span className="emoji">⏰</span>
                </div>
                <h3>Available Hours</h3>
                <p>
                  Mon–Fri: 9:00–18:00
                  <br />
                  Sat: 10:00–14:00
                </p>
              </div>
            </article>
          </div>

          <div className="contact-main">
            <div className="form-card contact-form-card">
              <div className="content">
                <h2>Share Your Vision</h2>
                <p className="lead">
                  Tell us about your journey so far and where you dream of going next.
                </p>

                {submitted && (
                  <div className="alert-success">
                    Thank you for reaching out! We&apos;ll be in touch shortly.
                  </div>
                )}

                <form className="mt-12" onSubmit={handleSubmit} noValidate>
                  <div className="field">
                    <label className="label" htmlFor="name">
                      Full Name *
                    </label>
                    <input
                      className="input"
                      id="name"
                      name="name"
                      type="text"
                      placeholder="Bernard Gamanga"
                      value={form.name}
                      onChange={handleChange}
                    />
                    {errors.name && <div className="error-text">{errors.name}</div>}
                  </div>

                  <div className="field">
                    <label className="label" htmlFor="email">
                      Email Address *
                    </label>
                    <input
                      className="input"
                      id="email"
                      name="email"
                      type="email"
                      placeholder="bernard@example.com"
                      value={form.email}
                      onChange={handleChange}
                    />
                    {errors.email && <div className="error-text">{errors.email}</div>}
                  </div>

                  <div className="field">
                    <label className="label" htmlFor="phone">
                      Phone Number
                    </label>
                    <input
                      className="input"
                      id="phone"
                      name="phone"
                      type="tel"
                      placeholder="+232 76 123 496"
                      value={form.phone}
                      onChange={handleChange}
                    />
                    {errors.phone && <div className="error-text">{errors.phone}</div>}
                  </div>

                  <div className="field">
                    <label className="label" htmlFor="subject">
                      Subject *
                    </label>
                    <select
                      className="select"
                      id="subject"
                      name="subject"
                      value={form.subject}
                      onChange={handleChange}
                    >
                      <option value="">Select a subject</option>
                      <option value="representation">Player Representation</option>
                      <option value="transfer">Transfer Inquiry</option>
                      <option value="scouting">Scouting Services</option>
                      <option value="partnership">Partnership Opportunity</option>
                      <option value="general">General Inquiry</option>
                    </select>
                    {errors.subject && <div className="error-text">{errors.subject}</div>}
                  </div>

                  <div className="field">
                    <label className="label" htmlFor="message">
                      Message *
                    </label>
                    <textarea
                      className="textarea"
                      id="message"
                      name="message"
                      rows={6}
                      placeholder="Tell us more about your inquiry..."
                      value={form.message}
                      onChange={handleChange}
                    />
                    {errors.message && <div className="error-text">{errors.message}</div>}
                  </div>

                  <button type="submit" className="btn primary contact-submit">
                    Send Message →
                  </button>
                </form>
              </div>
            </div>

            <div className="card contact-why-card">
              <div className="content">
                <h3 className="m-0">Why We Stand Apart?</h3>
                <ul>
                  <li>Elite FIFA-certified professionals with legendary achievements</li>
                  <li>Masterful navigation of global and local football landscapes</li>
                  <li>Bespoke mentorship tailored to each champion&apos;s unique journey</li>
                  <li>Unwavering commitment to integrity and excellence</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="section muted">
        <div className="container">
          <h2 className="center">Common Inquiries</h2>
          <div className="grid cols-2">
            <article className="card">
              <div className="content">
                <h3>How do I begin my journey with your agency?</h3>
                <p>
                  Reach out through our contact form or direct communication channels. We&apos;ll
                  evaluate your potential, schedule a consultation, and design a personalized
                  path to elevate your football career.
                </p>
              </div>
            </article>
            <article className="card">
              <div className="content">
                <h3>What investment is required for your services?</h3>
                <p>
                  Our fee structure reflects our commitment to excellence and is designed for
                  mutual success. We operate on a performance-based model that aligns with your
                  achievements and career milestones.
                </p>
              </div>
            </article>
            <article className="card">
              <div className="content">
                <h3>Do you nurture emerging talent?</h3>
                <p>
                  Absolutely! We specialize in identifying and developing young prodigies,
                  placing them in elite academies across Europe, Africa, and beyond. Early
                  mentorship is the foundation of legendary careers.
                </p>
              </div>
            </article>
          </div>
        </div>
      </section>
    </>
  );
}



