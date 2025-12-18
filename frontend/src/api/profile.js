export async function uploadAvatar(file) {
  const formData = new FormData();
  formData.append('avatar', file);

  const res = await fetch('/backend/api_profile_avatar.php', {
    method: 'POST',
    body: formData,
    credentials: 'include'
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to upload image');
  }
  return data;
}

export async function updateProfile(updates) {
  const res = await fetch('/backend/api_profile_update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify(updates)
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to update profile');
  }
  return data;
}

export async function getPlayerProfile() {
  const res = await fetch('/backend/api_player_profile.php', {
    method: 'GET',
    credentials: 'include'
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load player profile');
  }
  return data;
}

export async function savePlayerProfile(profile) {
  const res = await fetch('/backend/api_player_profile.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify(profile)
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to save player profile');
  }
  return data;
}




