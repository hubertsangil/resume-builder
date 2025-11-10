# Resume Builder Website
A website that builds a resume using forms

## Features
- User auth: register, login, logout.  
- Profile forms for personal info, education, work, skills, projects.  
- Resume template rendering from saved data.  
- Public link to view each resume.  
- Responsive UI built with TailwindCSS.  
- CSV or PDF export (optional).

## Tech stack
- Backend: PHP, Laravel.  
- Frontend: Blade, TailwindCSS  
- Database: PostgreSQL
- Dev tooling: Composer, npm / Vite.

## Quick setup

### Prerequisites
- PHP 8.x  
- Composer  
- Node.js and npm  
- MySQL

### Install
```bash
git clone <repo-url>
cd resume-builder
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
```

Configure database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resume_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_pass
```

Run migrations and seeders
```bash
php artisan migrate
php artisan db:seed
```

Run app
```bash
php artisan serve --host=127.0.0.1 --port=8000
# open http://127.0.0.1:8000
```


