# Implementation Plan - Internship Assignment

Create a user management system with registration, login, and profile management using a specific tech stack (PHP, MySQL, MongoDB, Redis).

## Proposed Changes

### Database Setup
- **MySQL**: Create a `users` table for authentication (id, email, password).
- **MongoDB**: Create a `profiles` collection for user details (user_id, age, dob, contact, etc.).
- **Redis**: Use for storing session tokens mapped to user IDs.

### [NEW] Frontend Files
- `index.html`: Main landing page, redirects to `login.html` or `profile.html`.
- `register.html`: Signup form using Bootstrap.
- `login.html`: Login form using Bootstrap.
- `profile.html`: Profile management form using Bootstrap.
- `js/register.js`: Handles registration AJAX request.
- `js/login.js`: Handles login AJAX request and stores token in `localStorage`.
- `js/profile.js`: Handles profile fetching and updating AJAX requests.

### [NEW] Backend Files
- `php/register.php`: Processes registration, stores in MySQL.
- `php/login.php`: Validates credentials, creates session in Redis, returns token.
- `php/profile.php`: CRUD for user profile in MongoDB, validates session via Redis.

## Verification Plan

### Automated Tests
- Test registration with valid/invalid data.
- Test login with valid/invalid credentials.
- Test profile update and persistency in MongoDB.
- Verify session expiration and token validation.

### Manual Verification
- Walk through the flow: Register -> Login -> Profile.
- Check `localStorage` for the session token.
- Verify data in MySQL and MongoDB directly.
