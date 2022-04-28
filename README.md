
# Credentialing Management System Laravel+Vue



## About Repository

A very simple Laravel 8 + Vue 2 + AdminLTE 3 based SPA Application.

## Tech Specification

- Laravel 8
- Vue 2 + VueRouter + vue-progressbar + sweetalert2 + laravel-vue-pagination
- Laravel Passport
- Admin LTE 3 + Bootstrap 4 + Font Awesome 5
- PHPUnit Test Case/Test Coverage

## Features

- Modal based Create+Edit, List with Pagination, Delete with Sweetalert
- Login, Register, Forget+Reset Password as default auth
- Profile, Update Profile, Change Password, Avatar
- Practice Management 
- Provider Management 
- Payer Management 
- Document Management 
- Reports 
- User Management
- Frontend and Backend User ACL with Gate Policy (type: admin/user)
- Simple Static Dashboard
- Developer Options for OAuth Clients and Personal Access Token

## Installation

- `git clone https://gitlab.tekboox.com/usama.bajwa/prg-cred-isb.git`
- `cd cred1/`
- `composer install`
- `cp .env.example .env`
- Update `.env` and set your database credentials, also import your database in mysql
- `php artisan key:generate`
- `php artisan passport:install`
- `npm install`
- `npm run dev`
- `php artisan serve`
