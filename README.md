# Laravel Project Setup

## Overview

An Event Management System for managing talk proposals, speaker registrations, and review processes. This system allows authenticated speakers to submit proposals, manage them, and enables reviewers to review and rate proposals. The system also provides an API for fetching proposal statistics.

## Features

- **Speaker Authentication**: Allows speakers to register, log in, and manage their talk proposals.
- **Talk Proposal Submission**: Speakers can submit talk proposals with attached PDFs and categorize them with tags.
- **Reviewer Dashboard**: Reviewers can view, filter, and review talk proposals.
- **Proposal Statistics API**: Provides API endpoints for statistics on talk proposals, including total count, average rating, and count by tag.


## Requirements

- **PHP 7.4** or higher
- **Composer**
- **Laravel 8** (or higher)
- **MySQL** (for database)

## Setup Instructions

### 1. Clone the Repository

Clone the repository to your local machine:

bash
git clone https://github.com/rajakhemant1/EventManagementSystem.git
cd EventManagementSystem.

### 2. Install PHP Dependencies

Install the PHP dependencies using Composer:

bash
composer install


### Configure Environment Variables

1. *Create the .env File*:

Copy the example environment file to create a new .env file:

bash
cp .env.example .env


2 *Set Up Database Configuration*:

Open the .env file and configure your database settings:

bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password


Make sure to replace your_database_name, your_database_username, and your_database_password with your actual database credentials.

4. *Generate Application Key*:
Generate a new application key for the Laravel project:

bash
php artisan key:generate

5. *Run Migrations*:
Run the database migrations to set up the necessary tables:

bash
php artisan migrate

6. *Start PHP Server*:
Open a new terminal and start the PHP development server:

bash
php artisan serve

The application will be accessible at http://127.0.0.1:8000 (or another port specified in the output).

7. *Run Seeders*:
To populate the database with initial data, run the following commands:

bash
php artisan db:seed 


8. *Login Details For Reviewer*:
You can use the following credentials to log in:

bash
EmailAddress=reviewer1@example.com
Password=12345678


## Summary
Cloned the repository and installed dependencies.
Configured the .env file for database settings.
Generated application key and run migrations.
Run the PHP server to access the application.
Run the seeders for user and loan details.
