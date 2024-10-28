Project Setup and Execution Guide

Prerequisites:
1. XAMPP Installation:
   - Ensure you have XAMPP installed, which includes Apache and MySQL.
   - XAMPP can be downloaded from apachefriends.org
Steps to Setup and Run the Project:
1. Open the Project:
   - Open your project in your preferred code editor (e.g., VSCode, Sublime Text).

2. Install Composer Dependencies:
   - Run the following command in your terminal:
     composer install
   - Optional: Update Composer dependencies if needed:
   composer update
   
3. Optimize Configuration Loading:
   - Run the following command to cache the configuration:
     php artisan config:cache
    
4. Generate Application Key (if needed):
   - Run the following command to generate the application key:
     php artisan key:generate


5. Run Migrations:
   - Run the following command to migrate the database:
     php artisan migrate
    
6. Serve the Project:
   - Run the following command to start the development server:
     php artisan serve
   - Access your project by navigating to `http://127.0.0.1:8000` in your web browser.

7. Log in to the system:
   - Finally, Use Username: Admin, Password: 12345678 to log in to the system.
   -After Logging in change your username and password.


This guide outlines the steps necessary to set up and run the project, ensuring all prerequisites and commands are clear and easy to follow.
