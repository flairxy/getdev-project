## Instructions

This project was developed using laravel and vue framework.

1.  Configure your .env file to match your database
2.  Run php artisan migrate:fresh --seed to create the DB tables (MySQL was used here) and seed the user with a role dead. The user password is "secret and email is "dean@localhost".
3.  Only the dean can add users (student or staff) and assign roles to the staffs. The default password for each created user is "secret". The dean can also create classes and assign a class to a staff with role teacher
