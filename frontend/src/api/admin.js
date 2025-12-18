// Admin-specific API helpers

export async function getPlatformStats() {
  const res = await fetch('/backend/api_admin_stats.php', {
    credentials: 'include'
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load platform stats');
  }
  return data;
}

export async function getUsersList() {
  const res = await fetch('/backend/api_users_list.php', {
    credentials: 'include'
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load users');
  }
  return data;
}

