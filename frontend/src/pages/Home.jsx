import { Link } from 'react-router-dom';

const services = [
  {
    title: 'Talent Cultivation',
    emoji: '🎯',
    description: 'Nurturing exceptional athletes through every phase of their journey to stardom.'
  },
  {
    title: 'Strategic Partnerships',
    emoji: '🤝',
    description:
      'Crafting mutually beneficial alliances that unlock extraordinary opportunities for our athletes.'
  },
  {
    title: 'Diamond Discovery',
    emoji: '🏆',
    description:
      "Uncovering hidden gems and polishing future champions from Sierra Leone's grassroots."
  },
  {
    title: 'Global Pathways',
    emoji: '🌍',
    description:
      'Creating bridges to prestigious leagues and academies across continents.'
  }
];

const stories = [
  {
    initials: 'M',
    name: 'Mohamed Kamara',
    highlight: 'Signed with Guinean club Horoya FC',
    country: 'Guinea'
  },
  {
    initials: 'A',
    name: 'Abdul Sesay',
    highlight: 'National Team Call-up',
    country: 'Sierra Leone'
  },
  {
    initials: 'I',
    name: 'Ibrahim Turay',
    highlight: 'Signed with BO Rangers',
    country: 'Sierra Leone'
  }
];

export default function Home() {
  return (
    <>
      <section className="hero home-hero">
        <div className="hero-overlay" />
        <div className="container hero-content">
          <div className="hero-text">
            <h1>Unleashing Dreams, Building Champions</h1>
            <p>
              Transforming Sierra Leone&apos;s rising stars into global football legends through
              passion and dedication.
            </p>
            <div className="hero-actions">
              <Link className="btn primary" to="/contact">
                Get Started →
              </Link>
              <Link className="btn ghost" to="/services">
                Learn More
              </Link>
            </div>
          </div>
          <div className="hero-side-card">
            <div className="hero-ball">⚽</div>
            <h3>Become a Legend</h3>
            <p>Join the journey from grassroots to greatness.</p>
          </div>
        </div>
      </section>

      <section className="section muted">
        <div className="container">
          <div className="section-header">
            <h2>Our Services</h2>
            <p className="lead">
              Bespoke mentorship and strategic guidance that transforms raw talent into
              professional excellence.
            </p>
          </div>
          <div className="grid cols-4">
            {services.map((service) => (
              <article className="card center" key={service.title}>
                <div className="content">
                  <div className="icon-box">
                    <span className="emoji">{service.emoji}</span>
                  </div>
                  <h3>{service.title}</h3>
                  <p>{service.description}</p>
                </div>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <h2>Success Stories</h2>
          <p className="lead">Recent achievements of our represented players.</p>
          <div className="grid cols-3">
            {stories.map((story) => (
              <article className="card center" key={story.name}>
                <div className="content">
                  <div className="icon-box story-icon">
                    {story.initials}
                  </div>
                  <h3 className="m-0">{story.name}</h3>
                  <p className="m-0 story-highlight">{story.highlight}</p>
                  <p className="m-0 story-country">{story.country}</p>
                </div>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="band">
        <div className="container">
          <h2>Ready to Write Your Football Legacy?</h2>
          <p>
            Join our family of extraordinary athletes and let us craft your path to immortality.
          </p>
          <Link className="btn band-btn" to="/contact">
            Contact Us Today
          </Link>
        </div>
      </section>
    </>
  );
}



