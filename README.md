# Community Watch

A full-stack missing persons platform built with PHP and MySQL. Community members can report missing persons, submit sightings, and the system automatically compares uploaded photos to flag potential matches.

---

## Features

- **User authentication** — register, log in, log out, forgot password
- **Report a missing person** — upload a photo (PNG or JPEG), location, NIN, and description
- **Report a sighting** — submit a photo of someone you may have seen
- **Automatic image matching** — sighting photos are compared against missing person reports; a match surfaces the volunteer's contact details
- **Active Reports board** — browse all missing persons currently on the platform
- **Session security** — 10-minute inactivity timeout, no-cache headers to block back-button access after logout
- **Dark glassmorphism UI** — built with Bootstrap 5 and Bootstrap Icons (no CDN, fully local)
- **Page transition loader** — smooth dark overlay between page navigations

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8+ (procedural, `mysqli` prepared statements) |
| Database | MySQL 8 via XAMPP |
| Frontend | Bootstrap 5.1.3, Bootstrap Icons 1.11.0 (local vendor bundle) |
| Auth | PHP sessions + `password_hash` / `password_verify` (bcrypt) |
| Image processing | PHP GD extension |

---

## Running Locally

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP)
- PHP GD extension enabled (on by default in XAMPP)

### Steps

1. **Clone the repo** into your XAMPP web root:
   ```bash
   git clone https://github.com/chuksyt/community-watch-revamped.git
   ```
   Place the folder inside `C:/xampp/htdocs/` (Windows) or `/Applications/XAMPP/htdocs/` (Mac).

2. **Start XAMPP** — enable both Apache and MySQL in the Control Panel.

3. **Create the database** — open [phpMyAdmin](http://localhost/phpmyadmin), click **Import**, and upload `schema.sql` from the project root.

4. **Open the app**:
   ```
   http://localhost/community-watch-revamped/index.php
   ```

5. **Register an account** and you're in.

> **Database credentials** — the app connects as `root` with no password, which is the XAMPP default. If your setup differs, edit `connection.php`.

---

## Project Structure

```
├── index.php               # Landing page (session-aware)
├── login.php               # Login
├── signup.php              # Registration
├── forgot_password.php     # Password reset (email + username verification)
├── choose.php              # Dashboard
├── search.php              # Report missing person form
├── sighting.php            # Report a sighting form
├── my_reports.php          # Active reports board
├── Complaint.php           # Missing person form processor
├── Volunteer.php           # Sighting form processor
├── similar.php             # Image comparison + match logic
├── Information.php         # Match found — volunteer contact details
├── Response.html           # No match result
├── thankyou.html           # Sighting submission confirmation
├── session_guard.php       # Centralised session/auth middleware
├── logout.php              # Session teardown
├── loader.js               # Page transition overlay
├── connection.php          # DB connection
├── schema.sql              # Database schema (run this first)
└── vendor/                 # Bootstrap 5 + Bootstrap Icons (local, no CDN)
```

---

## Author

**Nmerole Akachukwu** — Full Stack Developer  
[nmeroleebus@gmail.com](mailto:nmeroleebus@gmail.com)
