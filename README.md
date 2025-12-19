# Football Agency Sierra Leone

A comprehensive football agency management platform built with React frontend and PHP backend API.

## 🎯 Features

> [!NOTE]
> **Project Structure Overview**: This repository contains two versions of the application:
> 1. **Root Directory**: A server-side rendered **PHP Application** (Legacy/Monolith).
> 2. **`frontend/`**: A modern **React Application** that consumes the PHP API from `backend/`.
>
> You are currently looking at the documentation for the React version. For the PHP version, see `PROJECT-SUMMARY.md`.

- **User Management**: Four user roles (Admin, Player, Agent, Club Manager)
- **Role-Based Dashboard**: Customized dashboards for each user type
- **Opportunities Management**: Agents and Club Managers can create opportunities for Players
- **Messaging System**: Users can send messages to each other
- **Profile Management**: Complete profile setup with avatar uploads
- **Application System**: Players can apply to opportunities
- **Modern UI**: Responsive React frontend with clean design

## 🏗️ Tech Stack

- **Frontend**: React 18, React Router, Vite
- **Backend**: PHP 7.4+, MySQL
- **Authentication**: PHP Sessions, React Context
- **Styling**: CSS3 with custom properties

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7+ / MariaDB 10.3+
- Node.js 16+ and npm
- Web server (Apache/Nginx) or XAMPP

## 🚀 Quick Start

### 1. Clone the Repository

```bash
git clone <your-repo-url>
cd footballagency
```

### 2. Backend Setup (PHP)

1. **Configure Database Connection**
   ```bash
   cp backend/config.example.php backend/config.php
   ```
   
2. Edit `backend/config.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'football_agency_sl');
   ```

3. **Set Up Database**
   - Create the database: `CREATE DATABASE football_agency_sl;`
   - Run setup script: Visit `http://localhost/footballagency/backend/create_tables.php`
   - (Optional) Seed demo data: Visit `http://localhost/footballagency/backend/seed_demo_data.php`

### 3. Frontend Setup (React)

```bash
cd frontend
npm install
npm run dev
```

The React app will start on `http://localhost:5173`

### 4. Access the Application

- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost/footballagency/backend/

## 📁 Project Structure

```
footballagency/
├── backend/
│   ├── api_*.php          # API endpoints
│   ├── config.example.php # Database config template
│   ├── create_tables.php  # Database setup script
│   ├── seed_demo_data.php # Demo data seeder
│   └── session.php        # Session management
├── frontend/
│   ├── src/
│   │   ├── api/           # API client functions
│   │   ├── components/    # React components
│   │   ├── context/       # React context (Auth)
│   │   ├── pages/         # Page components
│   │   └── globals.css    # Global styles
│   ├── package.json
│   └── vite.config.js     # Vite configuration
├── images/                 # Static images
├── uploads/               # User uploaded files (avatars)
├── .gitignore
├── DEPLOYMENT.md          # Deployment guide
└── README.md              # This file
```

## 👥 User Roles

1. **Admin** - System administrators with full access
2. **Player** - Professional football players
3. **Agent** - FIFA-certified football agents
4. **Club Manager** - Managers representing football clubs

## 🔌 API Endpoints

### Authentication
- `POST /backend/api_login.php` - User login
- `POST /backend/api_logout.php` - User logout
- `GET /backend/api_me.php` - Get current user
- `POST /backend/api_register.php` - User registration

### Profile Management
- `GET /backend/api_player_profile.php` - Get player profile
- `POST /backend/api_player_profile.php` - Update player profile
- `POST /backend/api_profile_avatar.php` - Upload avatar
- `POST /backend/api_profile_update.php` - Update user profile

### Opportunities
- `GET /backend/api_opportunities.php` - List opportunities
- `POST /backend/api_opportunity_create.php` - Create opportunity (Agents/Managers)
- `POST /backend/api_applications.php` - Apply to opportunity

### Messaging
- `GET /backend/api_messages.php` - Get messages
- `POST /backend/api_message_send.php` - Send message
- `GET /backend/api_users_search.php` - Search users

### Agent Features
- `GET /backend/api_agent_profile.php` - Get agent profile
- `POST /backend/api_agent_profile.php` - Update agent profile
- `GET /backend/api_agent_players.php` - Get agent's players
- `POST /backend/api_agent_players.php` - Manage agent-player relationships

### Admin Features
- `GET /backend/api_admin_stats.php` - Platform statistics
- `GET /backend/api_users_list.php` - List all users

## 🔒 Security Features

- Password hashing with `password_hash()` (bcrypt)
- Prepared statements (SQL injection prevention)
- Input validation and sanitization
- Role-based access control (RBAC)
- Session-based authentication
- File upload validation

## 🛠️ Development

### Running in Development

1. **Start PHP Server** (if using XAMPP, start Apache + MySQL)
2. **Start React Dev Server**:
   ```bash
   cd frontend
   npm run dev
   ```

The Vite dev server proxies `/backend`, `/images`, and `/uploads` requests to `http://localhost/footballagency` to avoid CORS issues.

### Building for Production

```bash
cd frontend
npm run build
```

This creates an optimized build in `frontend/dist/` that you can deploy to your web server.

## 📝 Database Schema

The system uses the following main tables:
- `users` - User accounts and authentication
- `players` - Player-specific information
- `agents` - Agent-specific information
- `club_managers` - Club manager information
- `opportunities` - Opportunities/trials
- `applications` - Player applications to opportunities
- `messages` - User messages
- `agent_players` - Agent-player relationships

See `backend/create_tables.php` for the complete schema.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is created for educational purposes.

## 📧 Support

For questions or support, please open an issue in the GitHub repository.

---

**© 2025 Football Agency Sierra Leone**
