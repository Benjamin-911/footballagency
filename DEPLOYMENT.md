# Deployment Checklist

## ✅ Pre-Deployment Checklist

Before deploying to GitHub, ensure the following:

### 1. Security & Sensitive Data
- ✅ Remove hardcoded database credentials
- ✅ Use `config.example.php` as template
- ✅ Never commit `backend/config.php` (it's in .gitignore)
- ✅ Remove any API keys or secrets
- ✅ Review all files for hardcoded passwords

### 2. Files to Remove/Exclude
- ✅ Delete or ignore test files (`backend/test_*.php`)
- ✅ Delete or ignore debug files (`backend/debug_*.php`)
- ✅ Ensure `.gitignore` is properly configured
- ✅ Remove uploaded user files (avatars, etc.)

### 3. Documentation
- ✅ Update README.md with setup instructions
- ✅ Document environment variables needed
- ✅ Include database setup steps
- ✅ Add API documentation if needed

### 4. Code Quality
- ✅ Remove console.log statements from production code
- ✅ Remove commented-out debug code
- ✅ Ensure all error handling is appropriate
- ✅ Review for any hardcoded URLs or paths

### 5. Database Setup
- ✅ Provide database schema file (`backend/create_tables.php` or SQL export)
- ✅ Document how to run migrations/setup
- ✅ Include sample data seeding instructions if needed

## 📝 Setup Instructions for New Developers

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd footballagency
   ```

2. **Backend Setup (PHP)**
   ```bash
   # Copy the example config file
   cp backend/config.example.php backend/config.php
   
   # Edit config.php with your database credentials
   # Update DB_HOST, DB_USER, DB_PASS, DB_NAME
   
   # Set up database
   # Visit: http://localhost/footballagency/backend/create_tables.php
   # Visit: http://localhost/footballagency/backend/seed_demo_data.php (optional)
   ```

3. **Frontend Setup (React)**
   ```bash
   cd frontend
   npm install
   npm run dev
   ```

4. **Environment Variables**
   - Backend: Edit `backend/config.php` (created from `config.example.php`)
   - Frontend: No environment variables needed (uses proxy in development)

## 🔒 Security Notes

- **Never commit** `backend/config.php` with real credentials
- Use environment variables in production
- Keep uploaded files outside web root if possible
- Use prepared statements (already implemented)
- Hash all passwords (already using `password_hash()`)
- Validate all user inputs (already implemented)

## 🚀 Production Deployment Considerations

1. **Environment Setup**
   - Move to environment variables for database config
   - Set up proper error logging (disable display_errors)
   - Configure proper PHP session handling

2. **Frontend Build**
   ```bash
   cd frontend
   npm run build
   # Deploy the 'dist' folder contents
   ```

3. **Server Configuration**
   - Configure web server (Apache/Nginx) properly
   - Set up SSL/TLS certificates
   - Configure proper CORS headers if needed
   - Set appropriate file permissions

4. **Database**
   - Use a production database (not localhost)
   - Set up database backups
   - Use connection pooling if needed

5. **Security Headers**
   - Add security headers (CSP, X-Frame-Options, etc.)
   - Configure HTTPS redirect
   - Set up rate limiting for API endpoints

## 📋 Quick Start for Contributors

1. Fork the repository
2. Clone your fork
3. Follow "Setup Instructions" above
4. Create a feature branch
5. Make changes
6. Test locally
7. Submit a pull request

