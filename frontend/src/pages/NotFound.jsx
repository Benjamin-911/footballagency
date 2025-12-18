import { Link } from 'react-router-dom';

export default function NotFound() {
  return (
    <section className="section">
      <div className="container center">
        <h1>404</h1>
        <p className="lead">The page you are looking for could not be found.</p>
        <Link to="/" className="btn primary">
          Go back home
        </Link>
      </div>
    </section>
  );
}



