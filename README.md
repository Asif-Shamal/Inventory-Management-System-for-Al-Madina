
![Dashvoard fa](https://github.com/user-attachments/assets/7ba77400-a4a1-4bd3-bdba-8434ac4f13db)
![Dashboard en](https://github.com/user-attachments/assets/6df8ad03-1f25-45ad-988f-d8ad2282d468)
![Customer Invoic (partial paid )](https://github.com/user-attachments/assets/9519a57d-1f58-4338-86ee-b5734e1e507a)
![Approval Purchase](https://github.com/user-attachments/assets/7d8a70d6-8482-4f1a-b690-a47df31c7ead)
![Add Invoice](https://github.com/user-attachments/assets/92117e74-7868-4e7e-b5b5-18fcbc348f32)
![Add customer](https://github.com/user-attachments/assets/f2dd56f2-fa89-4362-8637-88f5dfe67922)

![Users all](https://github.com/user-attachments/assets/7ad67e6e-5306-400f-a080-c730ff52f84a)
![Supplier Wise Stock Report](https://github.com/user-attachments/assets/50d9fb15-9173-4f87-b787-348707646c78)
![Stock Report](https://github.com/user-attachments/assets/4a44909e-0e2b-4756-8955-4c8a1d15cb77)
![Stock Report All](https://github.com/user-attachments/assets/2dc14f73-8ba6-4a59-bb18-74d9b9b2541b)
![Purchase All](https://github.com/user-attachments/assets/5b1748a9-2312-4905-8797-9f1dd8caa8a3)
![Invoice Approve](https://github.com/user-attachments/assets/3e40df09-33c7-4dbd-82cf-47d398640142)



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
