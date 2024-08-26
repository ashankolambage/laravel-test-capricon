# Project Name
Blog App

## Introduction

This project is a web application built using Laravel, Vue.js, and Docker. It includes features such as user authentication, blog posts, a commenting system, and an admin dashboard. The application is designed to be easily deployable using Docker.

## How to Clone

To clone this repository, use the following command:

bash
git clone git@github.com:ashankolambage/laravel-test-capricon.git


Setup the Environment
Follow these steps to set up the development environment:

## Note: If you have any problems while setup this project please contact me.


## Option 1 - Using XAMPP

Project Setup Guide Using XAMPP on Windows
Introduction

This guide will help you set up the project using XAMPP on Windows. XAMPP is a popular, easy-to-install Apache distribution containing MariaDB, PHP, and Perl. This setup assumes that you already have XAMPP installed on your Windows machine.

Prerequisites

1. Download and Install XAMPP

    Visit the XAMPP website.

    Download the XAMPP installer for Windows.
    Run the installer and follow the on-screen instructions to install XAMPP.

2. Download and Install Composer

    Visit the Composer website.
    Download and run the Composer installer for Windows.
    Follow the installation instructions to install Composer.

3. Download and Install Node.js and npm

    Visit the Node.js website.
    Download and run the Node.js installer for Windows.
    Follow the installation instructions to install Node.js and npm.


4. Setup the Environment
    Configure XAMPP

    Open the XAMPP Control Panel.
    Start the Apache and MySQL services.
    Create a Database

5. Open phpMyAdmin in your web browser.
    Create a new database for your project.
    Note the database name as you will need it for configuration.
    Configure Environment Variables

6. Copy .env.example to .env:

7. Update the database configuration:

    ini
    Copy code
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel-test
    DB_USERNAME=root
    DB_PASSWORD=

8. Install PHP Dependencies

    Open a Command Prompt or PowerShell window.

    Ensure you are in the project directory.

    Run the following command to install PHP dependencies:

    bash
    composer install

9. Install Node.js Dependencies

    In the same Command Prompt or PowerShell window, run the following command to install Node.js dependencies:

    bash
    npm install
    Run Migrations and Seed the Database
    Run Migrations

10. Run the following command to migrate the database:

    bash
    php artisan migrate

11. Seed the Database

    Run the following command to seed the database with initial data:

    bash
    php artisan db:seed

12. Access the Application
    Open your web browser.

    Navigate to:
    http://localhost:8000




## Option 2 - Using Docker

1. Install Docker
    Download Docker: Visit the Docker website and download Docker for your operating system.
    Install Docker: Follow the installation instructions provided for your OS.

2. Install Docker Compose
    Download Docker Compose: Follow the instructions on the Docker Compose installation page for your operating system.
    Install Docker Compose: Follow the installation instructions provided.

3. Install Make
    Ubuntu/Debian: Install make using:
        sudo apt-get install make

    macOS: Install make using Homebrew:
        brew install make

    Windows: Install make using a package manager like Chocolatey:
        choco install make

4. Setup and Run
    Navigate to the Docker Folder

5. Start the Docker Containers

    bash
    make up

6. Access the Docker Shell

    bash
    make shell

7. Install PHP Dependencies

    bash
    composer install

8. Install Node.js Dependencies

    bash
    npm install

9. Run Migrations

    bash
    php artisan migrate

10. Seed the Database

    bash
    php artisan db:seed


11. Access the Application

    Open your web browser and go to:
    http://localhost:8000