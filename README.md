# TaskEra - Laravel API Project

A comprehensive Laravel project with an API for users and posts, an administrative dashboard, and push notifications.

## Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (for frontend assets)

## Installation and Setup

### 1. Clone the Project
```bash
git clone <repository-url>
cd TaskEra
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Set Up the Environment
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

### 4. Set Up the Database
```bash
# Modify the database settings in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=db_username
DB_PASSWORD=db_password

# Running Migrations and Seeds
php artisan migrate
php artisan db:seed
```

### 5. Email Setup
```bash
# Edit Email Settings in .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@taskera.com"
MAIL_FROM_NAME="${APP_NAME}"

# Administrator Email for Daily Reports
ADMIN_EMAIL=admin@taskera.com
```

### 6. Setting Up Broadcasting (WebSockets)
```bash
# Edit Broadcast Settings in .env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

### 7. Compile Assets
```bash
npm run dev
# Or for Production
npm run build
```

## Run Project

### Run Master Server
```bash
php artisan serve
```

### Run WebSockets (for Push Notifications)
```bash
php artisan websockets:serve
```

### Run Scheduler Tasks
```bash
php artisan schedule:work
```

## Features

### 🔐 Authentication
- JWT Authentication
- New User Registration (mobile, email, username, password)
- Login (mobile + password)
- Logout

### 📝 Posts
- Create a new post (title, description, contact_phone)
- View other users' posts (with a 512-character short description)
- Sort posts (newest first)
- Public API for displaying posts

### 🛠️ Dashboard
- AdminLTE Dashboard
- User Management (Full CRUD)
- Post Management (Full CRUD)
- Quick Statistics

### 🔔 Push Notifications
- Instant notifications when a new post is created
- Laravel WebSockets for local broadcasting

### 📊 Reports
- Automatic daily report (number of new users and posts)
- Send the report via Email

### 🧪 Testing
- Unit Tests for Authentication
- Feature Tests for Posts
- Repository Pattern
- Service Layer

## API Endpoints

### Authentication
```
POST /api/auth/register - Register a new user
POST /api/auth/login - Log in
POST /api/auth/logout - Log out
```

### Posts
```
GET /api/posts - View all posts (public)
POST /api/posts - Create a new post (auth required)
GET /api/posts/{id} - View a specific post
PUT /api/posts/{id} - Edit a post (auth required)
DELETE /api/posts/{id} - Delete a post (auth required)
```

### Dashboard
```
GET /admin - Dashboard
GET /admin/users - Administration Users
GET /admin/posts - Manage Posts
```

## Testing

### Running Tests
```bash
php artisan test
```

### API Specific Test
```bash
php artisan test --filter=AuthTest
php artisan test --filter=PostTest
```

## Postman Collection

The file `TaskEra_API.postman_collection.json` is included, containing all endpoints with:
- Environment Variables
- Example Data
- Automated Tests

### Importing the Collection
1. Open Postman
2. Import -> Upload Files
3. Select the file `TaskEra_API.postman_collection.json`
4. Add the environment variables:
- `base_url`: `http://localhost:8000`
- `token`: (This will be set automatically after logging in) Login)

## Deployment

### Server Requirements
- PHP 8.1+
- MySQL/PostgreSQL
- Redis (optional)
- Supervisor (for scheduling jobs)
- Nginx/Apache

### Deployment Steps
```bash
# On the Server
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Configure Supervisor for scheduling jobs
# Configure a Cron job: * * * * * php /path/to/artisan schedule:run
```