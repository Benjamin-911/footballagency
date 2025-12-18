export async function getOpportunitiesSummary() {
  const res = await fetch('/backend/api_opportunities.php', {
    method: 'GET',
    credentials: 'include'
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to load opportunities');
  }
  return data;
}

export async function applyToOpportunity(opportunityId) {
  const res = await fetch('/backend/api_applications.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({ opportunity_id: opportunityId })
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to apply for opportunity');
  }
  return data;
}

export async function createOpportunity(opportunityData) {
  const res = await fetch('/backend/api_opportunity_create.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify(opportunityData)
  });
  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    throw new Error(data.error || 'Failed to create opportunity');
  }
  return data;
}

