export async function apiLogin(email, password) {
  const res = await fetch('/backend/api_login.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({ email, password })
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Login failed');
  }
  return data;
}

export async function apiLogout() {
  const res = await fetch('/backend/api_logout.php', {
    method: 'POST',
    credentials: 'include'
  });
  if (!res.ok) {
    throw new Error('Logout failed');
  }
  return res.json().catch(() => ({}));
}

export async function apiMe() {
  const res = await fetch('/backend/api_me.php', {
    method: 'GET',
    credentials: 'include'
  });
  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to fetch user');
  }
  return data;
}

export async function apiRegister(user) {
  const res = await fetch('/backend/api_register.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify(user)
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Registration failed');
  }
  return data;
}



