import { useEffect, useState } from 'react';
import { Navigate, useLocation } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { getPlayerProfile, savePlayerProfile, uploadAvatar, updateProfile } from '../api/profile';
import { getOpportunitiesSummary, applyToOpportunity, createOpportunity } from '../api/opportunities';
import { getMessagesSummary, sendMessage, searchUsers } from '../api/messages';
import { getAgentProfile, saveAgentProfile, getMyPlayers, addPlayerToRoster, removePlayerFromRoster } from '../api/agent';
import { getPlatformStats, getUsersList } from '../api/admin';

export default function Dashboard() {
  const { user, loading, setUser } = useAuth();
  const location = useLocation();
  const [uploading, setUploading] = useState(false);
  const [uploadError, setUploadError] = useState(null);
  const [savingProfile, setSavingProfile] = useState(false);
  const [profileError, setProfileError] = useState(null);
  const [profileSuccess, setProfileSuccess] = useState(null);
  const [profileName, setProfileName] = useState(user?.name || '');
  const [profilePhone, setProfilePhone] = useState(user?.phone || '');
  const [playerProfile, setPlayerProfile] = useState(null);
  const [playerProfileError, setPlayerProfileError] = useState(null);
  const [loadingPlayerProfile, setLoadingPlayerProfile] = useState(false);
  const [savingPlayerProfile, setSavingPlayerProfile] = useState(false);
  const [playerProfileSuccess, setPlayerProfileSuccess] = useState(null);
  const [opportunitiesSummary, setOpportunitiesSummary] = useState({
    open_count: 0,
    items: []
  });
  const [oppsError, setOppsError] = useState(null);
  const [applyingId, setApplyingId] = useState(null);
  const [messagesSummary, setMessagesSummary] = useState({
    unread_count: 0,
    items: []
  });
  const [messagesError, setMessagesError] = useState(null);
  
  // Agent-specific state
  const [agentProfile, setAgentProfile] = useState(null);
  const [agentProfileError, setAgentProfileError] = useState(null);
  const [loadingAgentProfile, setLoadingAgentProfile] = useState(false);
  const [savingAgentProfile, setSavingAgentProfile] = useState(false);
  const [agentProfileSuccess, setAgentProfileSuccess] = useState(null);
  const [myPlayers, setMyPlayers] = useState([]);
  const [loadingMyPlayers, setLoadingMyPlayers] = useState(false);
  const [myPlayersError, setMyPlayersError] = useState(null);
  
  // Admin-specific state
  const [platformStats, setPlatformStats] = useState(null);
  const [loadingStats, setLoadingStats] = useState(false);
  const [usersList, setUsersList] = useState([]);
  const [loadingUsers, setLoadingUsers] = useState(false);
  
  // Opportunity creation state (for Agents/Club Managers)
  const [creatingOpportunity, setCreatingOpportunity] = useState(false);
  const [opportunityForm, setOpportunityForm] = useState({
    title: '',
    description: '',
    location: '',
    role_target: 'Player',
    closes_at: ''
  });
  const [opportunityFormError, setOpportunityFormError] = useState(null);
  const [opportunityFormSuccess, setOpportunityFormSuccess] = useState(null);
  
  // Message sending state
  const [showMessageForm, setShowMessageForm] = useState(false);
  const [messageReceiverId, setMessageReceiverId] = useState(null);
  const [messageReceiverName, setMessageReceiverName] = useState('');
  const [messageSubject, setMessageSubject] = useState('');
  const [messageBody, setMessageBody] = useState('');
  const [sendingMessage, setSendingMessage] = useState(false);
  const [messageFormError, setMessageFormError] = useState(null);
  const [messageFormSuccess, setMessageFormSuccess] = useState(null);
  const [userSearchQuery, setUserSearchQuery] = useState('');
  const [userSearchResults, setUserSearchResults] = useState([]);
  const [searchingUsers, setSearchingUsers] = useState(false);
  
  // Local editable copy of player profile fields
  const [playerForm, setPlayerForm] = useState({
    position: '',
    nationality: 'Sierra Leonean',
    current_club: '',
    preferred_foot: '',
    height_cm: '',
    weight_kg: '',
    date_of_birth: ''
  });
  
  // Agent profile form state
  const [agentForm, setAgentForm] = useState({
    license_number: '',
    fifa_certified: false,
    years_experience: 0,
    company_name: ''
  });

  // Derive role info (safe even when user is null)
  const role = user?.role || 'Player';
  const isPlayer = role === 'Player';
  const isAgent = role === 'Agent';
  const isManager = role === 'Club Manager';
  const isAdmin = role === 'Admin';

  // ALL useEffect hooks must be before early returns
  // Load extended player profile for players
  useEffect(() => {
    if (!user || !isPlayer) return;
    let cancelled = false;
    setLoadingPlayerProfile(true);
    setPlayerProfileError(null);
    (async () => {
      try {
        const data = await getPlayerProfile();
        if (!cancelled) {
          setPlayerProfile(data.player || null);
        }
      } catch (err) {
        if (!cancelled) {
          setPlayerProfileError(err.message || 'Failed to load player profile');
        }
      } finally {
        if (!cancelled) {
          setLoadingPlayerProfile(false);
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user, isPlayer]);

  useEffect(() => {
    if (playerProfile) {
      setPlayerForm({
        position: playerProfile.position || '',
        nationality: playerProfile.nationality || 'Sierra Leonean',
        current_club: playerProfile.current_club || '',
        preferred_foot: playerProfile.preferred_foot || '',
        height_cm: playerProfile.height_cm ?? '',
        weight_kg: playerProfile.weight_kg ?? '',
        date_of_birth: playerProfile.date_of_birth || ''
      });
    }
  }, [playerProfile]);

  // Load opportunities summary
  useEffect(() => {
    if (!user) return;
    let cancelled = false;
    setOppsError(null);
    (async () => {
      try {
        const data = await getOpportunitiesSummary();
        if (!cancelled) {
          setOpportunitiesSummary({
            open_count: data.open_count || 0,
            items: Array.isArray(data.items) ? data.items : []
          });
        }
      } catch (err) {
        if (!cancelled) {
          setOppsError(err.message || 'Failed to load opportunities');
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user, role]);

  // Load messages summary
  useEffect(() => {
    if (!user?.id) return;
    let cancelled = false;
    setMessagesError(null);
    (async () => {
      try {
        const data = await getMessagesSummary();
        if (!cancelled) {
          setMessagesSummary({
            unread_count: data.unread_count || 0,
            items: Array.isArray(data.items) ? data.items : []
          });
        }
      } catch (err) {
        if (!cancelled) {
          setMessagesError(err.message || 'Failed to load messages');
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user?.id]);

  // Handle user search for messaging
  useEffect(() => {
    if (!userSearchQuery || userSearchQuery.length < 2) {
      setUserSearchResults([]);
      return;
    }
    const timeoutId = setTimeout(async () => {
      setSearchingUsers(true);
      try {
        const data = await searchUsers(userSearchQuery);
        setUserSearchResults(data.users || []);
      } catch (err) {
        setUserSearchResults([]);
      } finally {
        setSearchingUsers(false);
      }
    }, 300);
    return () => clearTimeout(timeoutId);
  }, [userSearchQuery]);

  // Load agent profile for agents
  useEffect(() => {
    if (!user || !isAgent) return;
    let cancelled = false;
    setLoadingAgentProfile(true);
    setAgentProfileError(null);
    (async () => {
      try {
        const data = await getAgentProfile();
        if (!cancelled) {
          setAgentProfile(data.agent || null);
        }
      } catch (err) {
        if (!cancelled) {
          setAgentProfileError(err.message || 'Failed to load agent profile');
        }
      } finally {
        if (!cancelled) {
          setLoadingAgentProfile(false);
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user, isAgent]);

  // Load agent's players
  useEffect(() => {
    if (!user || !isAgent) return;
    let cancelled = false;
    setLoadingMyPlayers(true);
    setMyPlayersError(null);
    (async () => {
      try {
        const data = await getMyPlayers();
        if (!cancelled) {
          setMyPlayers(Array.isArray(data.players) ? data.players : []);
        }
      } catch (err) {
        if (!cancelled) {
          setMyPlayersError(err.message || 'Failed to load players');
        }
      } finally {
        if (!cancelled) {
          setLoadingMyPlayers(false);
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user, isAgent]);

  // Load admin stats
  useEffect(() => {
    if (!user || !isAdmin) return;
    let cancelled = false;
    setLoadingStats(true);
    (async () => {
      try {
        const data = await getPlatformStats();
        if (!cancelled) {
          setPlatformStats(data.stats || null);
        }
      } catch (err) {
        // Silently fail
      } finally {
        if (!cancelled) {
          setLoadingStats(false);
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user, isAdmin]);

  // Load users list for admin
  useEffect(() => {
    if (!user || !isAdmin) return;
    let cancelled = false;
    setLoadingUsers(true);
    (async () => {
      try {
        const data = await getUsersList();
        if (!cancelled) {
          setUsersList(Array.isArray(data.users) ? data.users : []);
        }
      } catch (err) {
        // Silently fail
      } finally {
        if (!cancelled) {
          setLoadingUsers(false);
        }
      }
    })();
    return () => {
      cancelled = true;
    };
  }, [user, isAdmin]);

  useEffect(() => {
    if (agentProfile) {
      setAgentForm({
        license_number: agentProfile.license_number || '',
        fifa_certified: agentProfile.fifa_certified ? true : false,
        years_experience: agentProfile.years_experience || 0,
        company_name: agentProfile.company_name || ''
      });
    }
  }, [agentProfile]);

  if (loading) {
    return (
      <section className="section">
        <div className="container center">
          <p>Loading your dashboard…</p>
        </div>
      </section>
    );
  }

  if (!user) {
    return <Navigate to="/login" state={{ from: location.pathname }} replace />;
  }

  const handleAvatarChange = async (event) => {
    const file = event.target.files?.[0];
    if (!file) return;

    setUploadError(null);
    setUploading(true);
    try {
      const data = await uploadAvatar(file);
      if (data.avatarUrl) {
        setUser((prev) => (prev ? { ...prev, avatarUrl: data.avatarUrl } : prev));
      }
    } catch (err) {
      setUploadError(err.message || 'Failed to upload image');
    } finally {
      setUploading(false);
      // Reset the input so the same file can be re-selected if needed
      event.target.value = '';
    }
  };

  const initial = (user.name || user.email || '?').charAt(0).toUpperCase();

  // Compute profile completeness based on key fields
  const computeCompleteness = () => {
    if (!isPlayer || !playerProfile) return 0;
    const keys = [
      'position',
      'nationality',
      'current_club',
      'preferred_foot',
      'height_cm',
      'weight_kg',
      'date_of_birth'
    ];
    let filled = 0;
    keys.forEach((key) => {
      const value = playerProfile[key];
      if (value !== null && value !== '' && value !== 0) {
        filled += 1;
      }
    });
    return Math.round((filled / keys.length) * 100);
  };

  const profileCompleteness = computeCompleteness();

  const handlePlayerFieldChange = (e) => {
    const { name, value } = e.target;
    setPlayerForm((prev) => ({
      ...prev,
      [name]: value
    }));
  };

  const handlePlayerProfileSubmit = async (event) => {
    event.preventDefault();
    if (!isPlayer) return;
    setPlayerProfileError(null);
    setPlayerProfileSuccess(null);
    setSavingPlayerProfile(true);
    try {
      const payload = {
        ...playerForm
      };
      const data = await savePlayerProfile(payload);
      if (data.player) {
        setPlayerProfile(data.player);
        setPlayerProfileSuccess('Player details updated.');
      }
    } catch (err) {
      setPlayerProfileError(err.message || 'Failed to save player details');
    } finally {
      setSavingPlayerProfile(false);
    }
  };

  const handleProfileSubmit = async (event) => {
    event.preventDefault();
    setProfileError(null);
    setProfileSuccess(null);
    setSavingProfile(true);
    try {
      const payload = {
        name: profileName,
        phone: profilePhone
      };
      const data = await updateProfile(payload);
      if (data.user) {
        setUser(data.user);
        setProfileSuccess('Profile updated successfully.');
      }
    } catch (err) {
      setProfileError(err.message || 'Failed to update profile');
    } finally {
      setSavingProfile(false);
    }
  };

  const handleApply = async (opportunityId) => {
    setApplyingId(opportunityId);
    setOppsError(null);
    try {
      await applyToOpportunity(opportunityId);
      const data = await getOpportunitiesSummary();
      setOpportunitiesSummary({
        open_count: data.open_count || 0,
        items: Array.isArray(data.items) ? data.items : []
      });
    } catch (err) {
      setOppsError(err.message || 'Failed to apply for opportunity');
    } finally {
      setApplyingId(null);
    }
  };

  // Handle opportunity creation (for Agents/Club Managers)
  const handleCreateOpportunity = async (event) => {
    event.preventDefault();
    if (!isAgent && !isManager && !isAdmin) return;
    setOpportunityFormError(null);
    setOpportunityFormSuccess(null);
    setCreatingOpportunity(true);
    try {
      await createOpportunity(opportunityForm);
      setOpportunityFormSuccess('Opportunity created successfully!');
      setOpportunityForm({
        title: '',
        description: '',
        location: '',
        role_target: 'Player',
        closes_at: ''
      });
      // Refresh opportunities list
      const data = await getOpportunitiesSummary();
      setOpportunitiesSummary({
        open_count: data.open_count || 0,
        items: Array.isArray(data.items) ? data.items : []
      });
    } catch (err) {
      setOpportunityFormError(err.message || 'Failed to create opportunity');
    } finally {
      setCreatingOpportunity(false);
    }
  };

  // Handle sending message
  const handleSendMessage = async (event) => {
    event.preventDefault();
    if (!messageReceiverId || !messageBody.trim()) {
      setMessageFormError('Please select a recipient and enter a message');
      return;
    }
    setMessageFormError(null);
    setMessageFormSuccess(null);
    setSendingMessage(true);
    try {
      await sendMessage(messageReceiverId, messageSubject, messageBody);
      setMessageFormSuccess('Message sent successfully!');
      setMessageBody('');
      setMessageSubject('');
      setMessageReceiverId(null);
      setMessageReceiverName('');
      setUserSearchQuery('');
      // Refresh messages
      const data = await getMessagesSummary();
      setMessagesSummary({
        unread_count: data.unread_count || 0,
        items: Array.isArray(data.items) ? data.items : []
      });
      setTimeout(() => setShowMessageForm(false), 1500);
    } catch (err) {
      setMessageFormError(err.message || 'Failed to send message');
    } finally {
      setSendingMessage(false);
    }
  };

  const selectMessageReceiver = (user) => {
    setMessageReceiverId(user.id);
    setMessageReceiverName(user.name);
    setUserSearchQuery('');
    setUserSearchResults([]);
  };

  const handleAgentFieldChange = (e) => {
    const { name, value, type, checked } = e.target;
    setAgentForm((prev) => ({
      ...prev,
      [name]: type === 'checkbox' ? checked : type === 'number' ? parseInt(value, 10) : value
    }));
  };

  const handleAgentProfileSubmit = async (event) => {
    event.preventDefault();
    if (!isAgent) return;
    setAgentProfileError(null);
    setAgentProfileSuccess(null);
    setSavingAgentProfile(true);
    try {
      const data = await saveAgentProfile(agentForm);
      if (data.agent) {
        setAgentProfile(data.agent);
        setAgentProfileSuccess('Agent profile updated.');
      }
    } catch (err) {
      setAgentProfileError(err.message || 'Failed to save agent profile');
    } finally {
      setSavingAgentProfile(false);
    }
  };

  // Compute agent completeness
  const computeAgentCompleteness = () => {
    if (!isAgent || !agentProfile) return 0;
    const keys = ['license_number', 'company_name', 'years_experience'];
    let filled = 0;
    keys.forEach((key) => {
      const value = agentProfile[key];
      if (value !== null && value !== '' && value !== 0) {
        filled += 1;
      }
    });
    return Math.round((filled / keys.length) * 100);
  };

  const agentCompleteness = computeAgentCompleteness();

  return (
    <section className="section">
      <div className="container">
        <div className="dashboard-header">
          <h2 className="dashboard-title">Welcome back, {user.name || user.email}</h2>
          <p className="dashboard-subtitle">
            You are signed in as <strong>{role}</strong>.
          </p>
        </div>

        <div className="grid cols-3 dashboard-summary-grid">
          <article className="card dashboard-summary-card">
            <div className="content">
              <p className="summary-label">
                {isPlayer ? 'Profile completeness' : isAgent ? 'Agent profile' : isAdmin ? 'Total Users' : 'Profile'}
              </p>
              <p className="summary-value">
                {isPlayer && loadingPlayerProfile
                  ? '…'
                  : isPlayer
                  ? `${profileCompleteness}%`
                  : isAgent && loadingAgentProfile
                  ? '…'
                  : isAgent
                  ? `${agentCompleteness}%`
                  : isAdmin && loadingStats
                  ? '…'
                  : isAdmin && platformStats
                  ? Object.values(platformStats.users_by_role || {}).reduce((a, b) => a + b, 0)
                  : '—'}
              </p>
              {isPlayer && (
                <div className="progress">
                  <div
                    className="progress-fill"
                    style={{ width: `${profileCompleteness}%` }}
                  />
                </div>
              )}
              {isAgent && (
                <div className="progress">
                  <div
                    className="progress-fill"
                    style={{ width: `${agentCompleteness}%` }}
                  />
                </div>
              )}
              <p className="summary-hint">
                {isPlayer
                  ? 'Complete your details to make a stronger impression with clubs and agents.'
                  : isAgent
                  ? 'Keep your professional profile updated.'
                  : isAdmin
                  ? 'Total active users across all roles.'
                  : 'Profile information.'}
              </p>
            </div>
          </article>
          <article className="card dashboard-summary-card">
            <div className="content">
              <p className="summary-label">
                {isAgent ? 'My Players' : isAdmin ? 'Opportunities' : 'Opportunities'}
              </p>
              <p className="summary-value">
                {isAgent
                  ? loadingMyPlayers
                    ? '…'
                    : myPlayers.length
                  : isAdmin && platformStats
                  ? platformStats.total_opportunities || 0
                  : opportunitiesSummary.open_count}
              </p>
              <p className="summary-hint">
                {isAgent
                  ? loadingMyPlayers
                    ? 'Loading players...'
                    : `${myPlayers.length} player${myPlayers.length !== 1 ? 's' : ''} in your roster.`
                  : isAdmin
                  ? 'Total opportunities on the platform.'
                  : opportunitiesSummary.open_count > 0
                  ? 'Open trials, scouting or contacts available.'
                  : 'No open opportunities right now.'}
              </p>
            </div>
          </article>
          <article className="card dashboard-summary-card">
            <div className="content">
              <p className="summary-label">
                {isAdmin ? 'Applications' : 'Messages'}
              </p>
              <p className="summary-value">
                {isAdmin && platformStats
                  ? platformStats.total_applications || 0
                  : messagesSummary.unread_count}
              </p>
              <p className="summary-hint">
                {isAdmin
                  ? 'Total applications submitted by players.'
                  : messagesSummary.unread_count > 0
                  ? 'You have unread messages waiting.'
                  : "You don't have unread messages."}
              </p>
            </div>
          </article>
        </div>

        <div className="grid cols-2 dashboard-grid">
          <article className="card">
            <div className="content">
              <h3>Your Profile</h3>
              <div className="avatar-row">
                <div className="avatar-circle">
                  {user.avatarUrl ? (
                    <img src={user.avatarUrl} alt="Profile" />
                  ) : (
                    <span className="avatar-initial">{initial}</span>
                  )}
                </div>
                <div className="avatar-actions">
                  <label className="btn secondary avatar-upload-btn">
                    {uploading ? 'Uploading…' : 'Upload photo'}
                    <input
                      type="file"
                      accept="image/png, image/jpeg"
                      onChange={handleAvatarChange}
                      hidden
                    />
                  </label>
                  {uploadError && <p className="error-text">{uploadError}</p>}
                  <p className="avatar-hint">JPG/PNG, max 2MB.</p>
                </div>
              </div>
              <form className="profile-form" onSubmit={handleProfileSubmit}>
                <div className="field">
                  <label className="label" htmlFor="profile-name">
                    Name
                  </label>
                  <input
                    id="profile-name"
                    className="input"
                    value={profileName}
                    onChange={(e) => setProfileName(e.target.value)}
                    required
                  />
                </div>
                <div className="field">
                  <label className="label" htmlFor="profile-phone">
                    Phone
                  </label>
                  <input
                    id="profile-phone"
                    className="input"
                    value={profilePhone}
                    onChange={(e) => setProfilePhone(e.target.value)}
                    placeholder="+232 76 123 456"
                  />
                </div>
                <div className="field">
                  <label className="label">Email</label>
                  <p>{user.email}</p>
                </div>
                <div className="field">
                  <label className="label">Role</label>
                  <p>{role}</p>
                </div>
                {profileError && <p className="error-text">{profileError}</p>}
                {profileSuccess && <p className="profile-success">{profileSuccess}</p>}
                <button type="submit" className="btn primary profile-save" disabled={savingProfile}>
                  {savingProfile ? 'Saving…' : 'Save changes'}
                </button>
              </form>
              {isPlayer && (
                <p>
                  Add your position, height, strong foot and highlight videos so clubs can quickly
                  evaluate you.
                </p>
              )}
              {isAgent && (
                <p>
                  Keep your portfolio of players up to date so clubs can discover new talent from
                  Sierra Leone.
                </p>
              )}
              {isManager && (
                <p>
                  Share your squad needs and upcoming trials to attract the right players and
                  agents.
                </p>
              )}
              {isAdmin && (
                <p>
                  Manage users and monitor activity across the platform. Future admin tools will
                  appear here.
                </p>
              )}
            </div>
          </article>

          <article className="card">
            <div className="content">
              <h3>Next Steps</h3>
              <ul>
                {isPlayer && (
                  <>
                    <li>Complete your player profile and upload highlight videos.</li>
                    <li>Share your preferred positions and leagues of interest.</li>
                    <li>Prepare documents like passports and medical reports.</li>
                  </>
                )}
                {isAgent && (
                  <>
                    <li>Add key players you represent.</li>
                    <li>Highlight recent transfers or success stories.</li>
                    <li>Connect with club managers in your network.</li>
                  </>
                )}
                {isManager && (
                  <>
                    <li>Define positions you are recruiting for.</li>
                    <li>Schedule scouting or trial dates.</li>
                    <li>Review potential candidates once they apply.</li>
                  </>
                )}
                {isAdmin && (
                  <>
                    <li>Review new user registrations.</li>
                    <li>Assign or adjust roles (Player, Agent, Manager).</li>
                    <li>Plan future features with the development team.</li>
                  </>
                )}
              </ul>

              {isPlayer && (
                <div className="player-form-wrapper">
                  <h4 className="player-form-title">Player details</h4>
                  {playerProfileError && <p className="error-text">{playerProfileError}</p>}
                  {playerProfileSuccess && (
                    <p className="profile-success">{playerProfileSuccess}</p>
                  )}
                  <form className="player-form" onSubmit={handlePlayerProfileSubmit}>
                    <div className="field">
                      <label className="label" htmlFor="position">
                        Position
                      </label>
                      <input
                        id="position"
                        name="position"
                        className="input"
                        value={playerForm.position}
                        onChange={handlePlayerFieldChange}
                        placeholder="Striker, Midfielder, Defender..."
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="nationality">
                        Nationality
                      </label>
                      <input
                        id="nationality"
                        name="nationality"
                        className="input"
                        value={playerForm.nationality}
                        onChange={handlePlayerFieldChange}
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="current_club">
                        Current club
                      </label>
                      <input
                        id="current_club"
                        name="current_club"
                        className="input"
                        value={playerForm.current_club}
                        onChange={handlePlayerFieldChange}
                        placeholder="e.g. FC Kallon"
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="preferred_foot">
                        Preferred foot
                      </label>
                      <select
                        id="preferred_foot"
                        name="preferred_foot"
                        className="select"
                        value={playerForm.preferred_foot}
                        onChange={handlePlayerFieldChange}
                      >
                        <option value="">Select</option>
                        <option value="Left">Left</option>
                        <option value="Right">Right</option>
                        <option value="Both">Both</option>
                      </select>
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="height_cm">
                        Height (cm)
                      </label>
                      <input
                        id="height_cm"
                        name="height_cm"
                        type="number"
                        className="input"
                        value={playerForm.height_cm}
                        onChange={handlePlayerFieldChange}
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="weight_kg">
                        Weight (kg)
                      </label>
                      <input
                        id="weight_kg"
                        name="weight_kg"
                        type="number"
                        className="input"
                        value={playerForm.weight_kg}
                        onChange={handlePlayerFieldChange}
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="date_of_birth">
                        Date of birth
                      </label>
                      <input
                        id="date_of_birth"
                        name="date_of_birth"
                        type="date"
                        className="input"
                        value={playerForm.date_of_birth}
                        onChange={handlePlayerFieldChange}
                      />
                    </div>
                    <button
                      type="submit"
                      className="btn secondary player-save"
                      disabled={savingPlayerProfile}
                    >
                      {savingPlayerProfile ? 'Saving…' : 'Save player details'}
                    </button>
                  </form>
                </div>
              )}

              {isAgent && (
                <div className="player-form-wrapper">
                  <h4 className="player-form-title">Agent details</h4>
                  {agentProfileError && <p className="error-text">{agentProfileError}</p>}
                  {agentProfileSuccess && (
                    <p className="profile-success">{agentProfileSuccess}</p>
                  )}
                  <form className="player-form" onSubmit={handleAgentProfileSubmit}>
                    <div className="field">
                      <label className="label" htmlFor="company_name">
                        Company name
                      </label>
                      <input
                        id="company_name"
                        name="company_name"
                        className="input"
                        value={agentForm.company_name}
                        onChange={handleAgentFieldChange}
                        placeholder="Your agency name"
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="license_number">
                        License number
                      </label>
                      <input
                        id="license_number"
                        name="license_number"
                        className="input"
                        value={agentForm.license_number}
                        onChange={handleAgentFieldChange}
                        placeholder="FIFA license or registration number"
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="years_experience">
                        Years of experience
                      </label>
                      <input
                        id="years_experience"
                        name="years_experience"
                        type="number"
                        className="input"
                        value={agentForm.years_experience}
                        onChange={handleAgentFieldChange}
                        min="0"
                      />
                    </div>
                    <div className="field">
                      <label style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                        <input
                          type="checkbox"
                          name="fifa_certified"
                          checked={agentForm.fifa_certified}
                          onChange={handleAgentFieldChange}
                        />
                        <span>FIFA Certified</span>
                      </label>
                    </div>
                    <button
                      type="submit"
                      className="btn secondary player-save"
                      disabled={savingAgentProfile}
                    >
                      {savingAgentProfile ? 'Saving…' : 'Save agent details'}
                    </button>
                  </form>
                </div>
              )}
            </div>
          </article>
        </div>

        <div className="grid cols-1 dashboard-grid">
          <article className="card">
            <div className="content">
              <h3>Activity</h3>
              <p>
                Soon you&apos;ll see recent applications, trial invitations, contract updates and
                messages between players, agents and clubs.
              </p>

              {oppsError && <p className="error-text">{oppsError}</p>}

              {isPlayer &&
                Array.isArray(opportunitiesSummary.items) &&
                opportunitiesSummary.items.length > 0 && (
                <div className="activity-section">
                  <h4 className="activity-subtitle">Open opportunities</h4>
                  <ul className="activity-list">
                    {opportunitiesSummary.items.map((opp) => (
                      <li key={opp.id} className="activity-item">
                        <div>
                          <strong>{opp.title}</strong>
                          {opp.location && <span className="activity-meta"> · {opp.location}</span>}
                        </div>
                        <button
                          type="button"
                          className="btn secondary activity-apply"
                          disabled={opp.applied || applyingId === opp.id}
                          onClick={() => handleApply(opp.id)}
                        >
                          {opp.applied ? 'Applied' : applyingId === opp.id ? 'Applying…' : 'Apply'}
                        </button>
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {messagesError && <p className="error-text">{messagesError}</p>}

              {Array.isArray(messagesSummary.items) && messagesSummary.items.length > 0 && (
                <div className="activity-section">
                  <h4 className="activity-subtitle">Recent messages</h4>
                  <ul className="activity-list">
                    {messagesSummary.items.map((msg) => (
                      <li key={msg.id} className="activity-item">
                        <div>
                          <strong>{msg.subject || 'No subject'}</strong>
                          <span className="activity-meta"> · from {msg.sender_name}</span>
                        </div>
                        <div className="activity-snippet">{msg.snippet}</div>
                      </li>
                    ))}
                  </ul>
                </div>
              )}

              {/* Create Opportunity Section (Agents/Club Managers) */}
              {(isAgent || isManager || isAdmin) && (
                <div className="activity-section">
                  <h4 className="activity-subtitle">Create New Opportunity</h4>
                  <form onSubmit={handleCreateOpportunity} className="profile-form">
                    {opportunityFormError && <p className="error-text">{opportunityFormError}</p>}
                    {opportunityFormSuccess && <p className="success-text">{opportunityFormSuccess}</p>}
                    <div className="field">
                      <label className="label" htmlFor="opp-title">
                        Title <span className="required">*</span>
                      </label>
                      <input
                        id="opp-title"
                        className="input"
                        value={opportunityForm.title}
                        onChange={(e) => setOpportunityForm({ ...opportunityForm, title: e.target.value })}
                        required
                        placeholder="e.g., Trial Opportunity for Midfielders"
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="opp-description">
                        Description
                      </label>
                      <textarea
                        id="opp-description"
                        className="input"
                        rows="4"
                        value={opportunityForm.description}
                        onChange={(e) => setOpportunityForm({ ...opportunityForm, description: e.target.value })}
                        placeholder="Describe the opportunity, requirements, etc."
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="opp-location">
                        Location
                      </label>
                      <input
                        id="opp-location"
                        className="input"
                        value={opportunityForm.location}
                        onChange={(e) => setOpportunityForm({ ...opportunityForm, location: e.target.value })}
                        placeholder="e.g., Manchester, UK"
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="opp-role-target">
                        Target Audience
                      </label>
                      <select
                        id="opp-role-target"
                        className="input"
                        value={opportunityForm.role_target}
                        onChange={(e) => setOpportunityForm({ ...opportunityForm, role_target: e.target.value })}
                      >
                        <option value="Player">Players</option>
                        <option value="Agent">Agents</option>
                        <option value="Club Manager">Club Managers</option>
                        <option value="All">All Users</option>
                      </select>
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="opp-closes-at">
                        Closes At (optional)
                      </label>
                      <input
                        id="opp-closes-at"
                        className="input"
                        type="date"
                        value={opportunityForm.closes_at}
                        onChange={(e) => setOpportunityForm({ ...opportunityForm, closes_at: e.target.value })}
                      />
                    </div>
                    <button
                      type="submit"
                      className="btn primary"
                      disabled={creatingOpportunity}
                    >
                      {creatingOpportunity ? 'Creating…' : 'Create Opportunity'}
                    </button>
                  </form>
                </div>
              )}

              {/* Send Message Section */}
              <div className="activity-section">
                <h4 className="activity-subtitle">Send Message</h4>
                {!showMessageForm ? (
                  <button
                    type="button"
                    className="btn secondary"
                    onClick={() => setShowMessageForm(true)}
                  >
                    Compose Message
                  </button>
                ) : (
                  <form onSubmit={handleSendMessage} className="profile-form">
                    {messageFormError && <p className="error-text">{messageFormError}</p>}
                    {messageFormSuccess && <p className="success-text">{messageFormSuccess}</p>}
                    <div className="field">
                      <label className="label" htmlFor="message-receiver">
                        To <span className="required">*</span>
                      </label>
                      {messageReceiverId ? (
                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                          <span>{messageReceiverName}</span>
                          <button
                            type="button"
                            className="btn secondary"
                            onClick={() => {
                              setMessageReceiverId(null);
                              setMessageReceiverName('');
                              setUserSearchQuery('');
                            }}
                          >
                            Change
                          </button>
                        </div>
                      ) : (
                        <>
                          <input
                            id="message-receiver"
                            className="input"
                            value={userSearchQuery}
                            onChange={(e) => setUserSearchQuery(e.target.value)}
                            placeholder="Search for a user by name or email..."
                          />
                          {searchingUsers && <p>Searching...</p>}
                          {userSearchResults.length > 0 && (
                            <ul style={{ 
                              border: '1px solid #ddd', 
                              borderRadius: '4px', 
                              maxHeight: '200px', 
                              overflowY: 'auto',
                              marginTop: '5px',
                              padding: '0',
                              listStyle: 'none'
                            }}>
                              {userSearchResults.map((u) => (
                                <li
                                  key={u.id}
                                  onClick={() => selectMessageReceiver(u)}
                                  style={{
                                    padding: '10px',
                                    cursor: 'pointer',
                                    borderBottom: '1px solid #eee'
                                  }}
                                  onMouseEnter={(e) => e.target.style.backgroundColor = '#f5f5f5'}
                                  onMouseLeave={(e) => e.target.style.backgroundColor = 'transparent'}
                                >
                                  <strong>{u.name}</strong> ({u.email}) - {u.role}
                                </li>
                              ))}
                            </ul>
                          )}
                        </>
                      )}
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="message-subject">
                        Subject
                      </label>
                      <input
                        id="message-subject"
                        className="input"
                        value={messageSubject}
                        onChange={(e) => setMessageSubject(e.target.value)}
                        placeholder="Message subject (optional)"
                      />
                    </div>
                    <div className="field">
                      <label className="label" htmlFor="message-body">
                        Message <span className="required">*</span>
                      </label>
                      <textarea
                        id="message-body"
                        className="input"
                        rows="5"
                        value={messageBody}
                        onChange={(e) => setMessageBody(e.target.value)}
                        required
                        placeholder="Type your message here..."
                      />
                    </div>
                    <div style={{ display: 'flex', gap: '10px' }}>
                      <button
                        type="submit"
                        className="btn primary"
                        disabled={sendingMessage || !messageReceiverId}
                      >
                        {sendingMessage ? 'Sending…' : 'Send Message'}
                      </button>
                      <button
                        type="button"
                        className="btn secondary"
                        onClick={() => {
                          setShowMessageForm(false);
                          setMessageBody('');
                          setMessageSubject('');
                          setMessageReceiverId(null);
                          setMessageReceiverName('');
                          setUserSearchQuery('');
                          setMessageFormError(null);
                          setMessageFormSuccess(null);
                        }}
                      >
                        Cancel
                      </button>
                    </div>
                  </form>
                )}
              </div>

              {isAgent && !loadingMyPlayers && (
                <div className="activity-section">
                  <h4 className="activity-subtitle">My Players</h4>
                  {myPlayersError && <p className="error-text">{myPlayersError}</p>}
                  {myPlayers.length === 0 ? (
                    <p>You don't have any players in your roster yet. Start by connecting with players to represent them.</p>
                  ) : (
                    <ul className="activity-list">
                      {myPlayers.map((player) => (
                        <li key={player.id} className="activity-item">
                          <div>
                            <strong>{player.player_name}</strong>
                            {player.position && (
                              <span className="activity-meta"> · {player.position}</span>
                            )}
                            {player.current_club && (
                              <span className="activity-meta"> · {player.current_club}</span>
                            )}
                          </div>
                          <div className="activity-snippet">
                            {player.player_email} {player.signed_date && `· Signed: ${player.signed_date}`}
                          </div>
                        </li>
                      ))}
                    </ul>
                  )}
                </div>
              )}

              {isAdmin && platformStats && (
                <div className="activity-section">
                  <h4 className="activity-subtitle">Platform Statistics</h4>
                  <div className="grid cols-2" style={{ gap: '16px', marginTop: '16px' }}>
                    <div>
                      <strong>Users by Role:</strong>
                      <ul style={{ marginTop: '8px', paddingLeft: '20px' }}>
                        {Object.entries(platformStats.users_by_role || {}).map(([role, count]) => (
                          <li key={role}>
                            {role}: {count}
                          </li>
                        ))}
                      </ul>
                    </div>
                    <div>
                      <strong>Other Stats:</strong>
                      <ul style={{ marginTop: '8px', paddingLeft: '20px' }}>
                        <li>Open Opportunities: {platformStats.open_opportunities || 0}</li>
                        <li>Total Applications: {platformStats.total_applications || 0}</li>
                        <li>Total Messages: {platformStats.total_messages || 0}</li>
                        <li>Agent-Player Relationships: {platformStats.agent_player_relationships || 0}</li>
                      </ul>
                    </div>
                  </div>
                </div>
              )}

              {isAdmin && usersList.length > 0 && (
                <div className="activity-section" style={{ marginTop: '24px' }}>
                  <h4 className="activity-subtitle">Recent Users</h4>
                  <ul className="activity-list">
                    {usersList.slice(0, 10).map((usr) => (
                      <li key={usr.id} className="activity-item">
                        <div>
                          <strong>{usr.name}</strong>
                          <span className="activity-meta"> · {usr.role}</span>
                        </div>
                        <div className="activity-snippet">{usr.email}</div>
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </div>
          </article>
        </div>
      </div>
    </section>
  );
}

