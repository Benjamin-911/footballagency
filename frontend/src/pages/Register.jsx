import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { apiRegister } from '../api/auth';

export default function Register() {
  const { user } = useAuth();
  const navigate = useNavigate();
  const isAdmin = user?.role === 'Admin';

  const [form, setForm] = useState({
    name: '',
    email: '',
    password: '',
    role: 'Player'
  });
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);
  const [submitting, setSubmitting] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);
    setSuccess(null);
    setSubmitting(true);

    const payload = {
      ...form,
      // For non-admin users, the backend will force this to Player anyway,
      // but we set it explicitly here for clarity.
      role: isAdmin ? form.role : 'Player'
    };

    try {
      await apiRegister(payload);
      setSuccess('Registration successful. You can now log in.');
      setForm({
        name: '',
        email: '',
        password: '',
        role: 'Player'
      });
      setTimeout(() => navigate('/login'), 2000);
    } catch (err) {
      setError(err.message || 'Registration failed');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <section className="section">
      <div className="container center">
        <div className="login-card">
          <h1>Create an Account</h1>

          {error && <div className="alert-error">{error}</div>}
          {success && <div className="alert-success">{success}</div>}

          <form className="login-form" onSubmit={handleSubmit}>
            <div className="field">
              <label className="label" htmlFor="name">
                Full name
              </label>
              <input
                id="name"
                name="name"
                type="text"
                className="input"
                required
                value={form.name}
                onChange={handleChange}
              />
            </div>

            <div className="field">
              <label className="label" htmlFor="email">
                Email
              </label>
              <input
                id="email"
                name="email"
                type="email"
                className="input"
                required
                value={form.email}
                onChange={handleChange}
              />
            </div>

            <div className="field">
              <label className="label" htmlFor="password">
                Password
              </label>
              <input
                id="password"
                name="password"
                type="password"
                className="input"
                required
                value={form.password}
                onChange={handleChange}
              />
            </div>

            {isAdmin && (
              <div className="field">
                <label className="label" htmlFor="role">
                  Account type
                </label>
                <select
                  id="role"
                  name="role"
                  className="select"
                  value={form.role}
                  onChange={handleChange}
                >
                  <option value="Player">Player</option>
                  <option value="Agent">Agent</option>
                  <option value="Club Manager">Club Manager</option>
                  <option value="Admin">Admin</option>
                </select>
              </div>
            )}

            {!isAdmin && (
              <p className="register-note">
                You&apos;ll be registered as a <strong>Player</strong>. Other roles can be
                assigned later by an admin.
              </p>
            )}

            <button type="submit" className="btn primary login-submit" disabled={submitting}>
              {submitting ? 'Registering…' : 'Register'}
            </button>
          </form>
        </div>
      </div>
    </section>
  );
}

