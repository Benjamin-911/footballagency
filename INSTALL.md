# Installation Guide - Football Agency Sierra Leone User Management System

## Quick Start Guide

Follow these steps to set up the user management system on your local machine.

### Step 1: Prerequisites Check

Ensure you have the following installed:
- ✅ Web Server (Apache/Nginx)
- ✅ PHP 7.4 or higher
- ✅ MySQL/MariaDB or SQLite
- ✅ phpMyAdmin (optional but recommended)

**Check PHP version:**
```bash
php -v
```

**Check MySQL version:**
```bash
mysql --version
```

### Step 2: Setup Web Server

#### Option A: Using XAMPP (Windows/Mac/Linux)
1. Download and install XAMPP from https://www.apachefriends.org/
2. Start Apache and MySQL from XAMPP Control Panel
3. Place project in `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac)

#### Option B: Using WAMP (Windows)
1. Download and install WAMP from https://www.wampserver.com/
2. Start WAMP services
3. Place project in `C:\wamp64\www\`

#### Option C: Using Laragon (Windows)
1. Download and install Laragon from https://laragon.org/
2. Place project in Laragon's `www` directory
3. Start Laragon

### Step 3: Create Database

#### Method 1: Using phpMyAdmin (Recommended)

1. **Open phpMyAdmin**
   - URL: `http://localhost/phpmyadmin`
   - Default username: `root`
   - Default password: (leave empty)

2. **Import the schema**
   - Click on "Import" in the top menu
   - Click "Choose File" and select `database/schema.sql`
   - Click "Go" to import

3. **Verify database creation**
   - You should see `football_agency_sl` database
   - Check the `users` table has 8 records

#### Method 2: Using MySQL Command Line

```bash
# Login to MySQL
mysql -u root -p

# Execute the schema file
mysql -u root -p < database/schema.sql

# Verify
mysql -u root -p
USE football_agency_sl;
SELECT COUNT(*) FROM users;
# Should return 8
```

### Step 4: Configure Database Connection

1. **Open** `backend/config.php` in a text editor

2. **Update connection settings** if necessary:
   ```php
   define('DB_HOST', 'localhost');      // Usually localhost
   define('DB_USER', 'root');            // Your MySQL username
   define('DB_PASS', '');                // Your MySQL password
   define('DB_NAME', 'football_agency_sl'); // Database name
   ```

3. **Save** the file

### Step 5: Test the Installation

1. **Open your browser** and navigate to:
   ```
   http://localhost/backend/test_api.php
   ```

2. **Expected Results:**
   - Page displays statistics showing 2 users per role (8 total)
   - Table showing all users with their details
   - Role-specific information displayed correctly

3. **Test API Endpoint:**
   ```
   http://localhost/backend/users.php?action=all
   ```
   You should see JSON output with all users

### Step 6: Test CRUD Operations

#### Test GET Request
```bash
curl http://localhost/backend/users.php?action=all
```

#### Test POST Request (Create)
```bash
curl -X POST http://localhost/backend/users.php \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Player",
    "email": "testplayer@example.com",
    "role": "Player",
    "password": "test123",
    "phone": "+232 76 123 999"
  }'
```

#### Test PUT Request (Update)
```bash
curl -X PUT http://localhost/backend/users.php \
  -H "Content-Type: application/json" \
  -d '{
    "id": 1,
    "phone": "+232 76 999 888"
  }'
```

#### Test DELETE Request
```bash
curl -X DELETE http://localhost/backend/users.php?id=9
```

### Step 7: Screenshot Database

To fulfill the assignment requirement:

1. **Open phpMyAdmin**: `http://localhost/phpmyadmin`
2. **Select** `football_agency_sl` database
3. **Click** on `users` table
4. **Click** "Browse" to view all records
5. **Take screenshot** (Windows: Win+Shift+S, Mac: Cmd+Shift+4)

**Recommended Screenshots:**
- `users` table with all 8 users
- `players` table with 2 players
- `agents` table with 2 agents
- `club_managers` table with 2 managers

## Troubleshooting

### Issue 1: "Access denied" Database Error

**Solution:**
1. Check `backend/config.php` has correct credentials
2. Verify MySQL is running
3. Try default root user with empty password

### Issue 2: "Table doesn't exist"

**Solution:**
1. Database wasn't created properly
2. Re-import `database/schema.sql`
3. Verify database name is correct

### Issue 3: PHP Error on test page

**Solution:**
1. Enable PHP error reporting in `php.ini`
2. Check PHP version: `php -v` (should be 7.4+)
3. Verify mysqli extension is enabled

### Issue 4: 404 Not Found

**Solution:**
1. Check web server is running
2. Verify correct URL path
3. Check file permissions

### Issue 5: CORS Errors (if testing from different domain)

**Solution:**
1. Already handled in `users.php` with CORS headers
2. If issues persist, check web server configuration

## Verification Checklist

- [ ] Web server is running (Apache/Nginx)
- [ ] MySQL is running
- [ ] Database `football_agency_sl` exists
- [ ] `users` table has 8 records
- [ ] `players` table has 2 records
- [ ] `agents` table has 2 records
- [ ] `club_managers` table has 2 records
- [ ] `test_api.php` page loads successfully
- [ ] API returns JSON data
- [ ] Screenshots captured
- [ ] All CRUD operations work

## Next Steps

1. ✅ Setup complete
2. ✅ Test all functionality
3. 📸 Capture database screenshots
4. 📝 Create GitHub repository
5. 🚀 Upload files to GitHub
6. 📤 Submit assignment

## Support

If you encounter issues:
1. Check this troubleshooting guide
2. Review error messages carefully
3. Verify all prerequisites are installed
4. Contact your instructor if problems persist

---

**Good luck with your assignment! 🎓**

