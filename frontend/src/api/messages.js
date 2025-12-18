export async function getMessagesSummary() {
  const res = await fetch('/backend/api_messages.php', {
    method: 'GET',
    credentials: 'include'
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load messages');
  }
  return data;
}

export async function sendMessage(receiverId, subject, body) {
  const res = await fetch('/backend/api_message_send.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({
      receiver_id: receiverId,
      subject: subject || '',
      body: body
    })
  });
  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to send message');
  }
  return data;
}

export async function searchUsers(query) {
  const res = await fetch(`/backend/api_users_search.php?q=${encodeURIComponent(query)}`, {
    credentials: 'include'
  });
  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to search users');
  }
  return data;
}

