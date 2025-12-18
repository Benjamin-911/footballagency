// Agent-specific API helpers

export async function getAgentProfile() {
  const res = await fetch('/backend/api_agent_profile.php', {
    credentials: 'include'
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load agent profile');
  }
  return data;
}

export async function saveAgentProfile(profileData) {
  const res = await fetch('/backend/api_agent_profile.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify(profileData)
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to save agent profile');
  }
  return data;
}

export async function getMyPlayers() {
  const res = await fetch('/backend/api_agent_players.php', {
    credentials: 'include'
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load players');
  }
  return data;
}

export async function addPlayerToRoster(playerId, signedDate, notes) {
  const res = await fetch('/backend/api_agent_players.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({
      player_id: playerId,
      signed_date: signedDate || new Date().toISOString().split('T')[0],
      notes: notes || ''
    })
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to add player');
  }
  return data;
}

export async function removePlayerFromRoster(playerId) {
  const res = await fetch('/backend/api_agent_players.php', {
    method: 'DELETE',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({ player_id: playerId })
  });
  const data = await res.json();
  if (!res.ok) {
    throw new Error(data.error || 'Failed to remove player');
  }
  return data;
}

export async function searchPlayers(query) {
  // For now, return empty - we can add a search API later
  // This would search users with role='Player' by name/email
  return { players: [] };
}

