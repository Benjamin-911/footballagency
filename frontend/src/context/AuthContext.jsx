import { createContext, useContext, useEffect, useState } from 'react';
import { apiLogin, apiLogout, apiMe } from '../api/auth';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    let isMounted = true;
    (async () => {
      try {
        const data = await apiMe();
        if (isMounted) {
          setUser(data.user || null);
        }
      } catch (e) {
        // Ignore initial error
      } finally {
        if (isMounted) setLoading(false);
      }
    })();
    return () => {
      isMounted = false;
    };
  }, []);

  const login = async (email, password) => {
    setError(null);
    const data = await apiLogin(email, password);
    setUser(data.user || null);
    return data.user || null;
  };

  const logout = async () => {
    setError(null);
    await apiLogout();
    setUser(null);
  };

  const value = {
    user,
    loading,
    error,
    setError,
    setUser,
    login,
    logout
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return ctx;
}


