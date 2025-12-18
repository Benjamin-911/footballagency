import { useState } from 'react';
import { NavLink, Outlet, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const navClass = ({ isActive }) => (isActive ? 'active' : undefined);

export default function Layout() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const [menuOpen, setMenuOpen] = useState(false);

  const closeMenu = () => setMenuOpen(false);

  const handleLogout = async () => {
    try {
      await logout();
      navigate('/login');
    } catch (e) {
      // eslint-disable-next-line no-console
      console.error(e);
    }
  };

  return (
    <>
      <header className="header">
        <div className="container navbar">
          <a className="brand" href="/" aria-label="Football Agency Sierra Leone">
            <div className="logo">
              <img
                src="/images/logo.jpg"
                alt="Football Agency Sierra Leone Logo"
                className="logo-img"
              />
            </div>
            <div>
              <p className="brand-title">
                Football Agency <span className="flag-pill" aria-hidden="true" />
              </p>
              <p className="brand-sub">Sierra Leone</p>
            </div>
          </a>
          <button
            type="button"
            className="nav-toggle"
            aria-label="Toggle navigation"
            onClick={() => setMenuOpen((open) => !open)}
          >
            <span />
            <span />
            <span />
          </button>
          <nav className={`nav ${menuOpen ? 'nav-open' : ''}`} aria-label="Primary">
            <NavLink to="/" end className={navClass} onClick={closeMenu}>
              Home
            </NavLink>
            <NavLink to="/services" className={navClass} onClick={closeMenu}>
              Services
            </NavLink>
            <NavLink to="/contact" className={navClass} onClick={closeMenu}>
              Contact
            </NavLink>
            {user && (
              <NavLink to="/dashboard" className={navClass} onClick={closeMenu}>
                Dashboard
              </NavLink>
            )}
            {user?.role === 'Admin' && (
              <NavLink to="/register" className={navClass} onClick={closeMenu}>
                Register
              </NavLink>
            )}
            {user ? (
              <>
                <span className="nav-user">Hi, {user.name || user.email}</span>
                <button type="button" className="nav-logout" onClick={handleLogout}>
                  Logout
                </button>
              </>
            ) : (
              <NavLink to="/login" className={navClass} onClick={closeMenu}>
                Login
              </NavLink>
            )}
          </nav>
        </div>
      </header>

      <main>
        <Outlet />
      </main>

      <footer className="footer">
        <div className="container">
          <div className="grid cols-3">
            <div>
              <div className="brand footer-brand">
                <div className="logo footer-logo">
                  <img
                    src="/images/logo.jpg"
                    alt="Football Agency Sierra Leone Logo"
                    className="logo-img"
                  />
                </div>
                <div>
                  <h3 className="m-0">Football Agency</h3>
                  <p className="m-0 footer-sub">Sierra Leone</p>
                </div>
              </div>
              <p>
                Connecting talented Sierra Leonean footballers with international opportunities
                and managing professional careers.
              </p>
            </div>
            <div>
              <h3>Contact Us</h3>
              <p>
                15 Wilkinson Road, Freetown
                <br />
                Sierra Leone
              </p>
              <p>+232 76 123 496</p>
              <p>info@footballagentsl.com</p>
            </div>
            <div>
              <h3>Follow Us</h3>
              <div className="socials">
                <a href="#" aria-label="Facebook">
                  f
                </a>
                <a href="#" aria-label="Twitter">
                  t
                </a>
                <a href="#" aria-label="Instagram">
                  i
                </a>
                <a href="#" aria-label="LinkedIn">
                  in
                </a>
              </div>
            </div>
          </div>
        </div>
        <div className="copyright">
          © {new Date().getFullYear()} Football Agency Sierra Leone. All rights reserved.
        </div>
      </footer>
    </>
  );
}


