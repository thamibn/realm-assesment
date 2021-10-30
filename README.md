# Setup
Realm Digital Simple Practical Assessment

``composer install``

to test email notification I suggest you use mailtrap.io and change email settings on  `.env` file

to the birthday wishes you can run the below command, and it will send one email with all employees having birthdays.

``php artisan birthday:wishes``

the above command can be configured with a schedule, so it can run automatically once per day.
