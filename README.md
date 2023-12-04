 
### App Info
The app has the following functionalities
- a page to list users and see how many notifications are still to be read.
- o List user basic info, plus the unread notification count.
- o Click on a user to “impersonate him” and see a simple home page with the classic notification 
icon with unread counter on the top bar. 
▪ Click on the counter to see the notification list.
▪ Click on the notification to set it as read.
- a form to update a user’s notifications settings
- o Switch on-screen notifications on/off
- o Change Email
- o Change Phone number (Twilio verify api)
- a page to post new notifications
- o Notifications should have
▪ a type: marketing, invoices, system
▪ a short text
▪ an expiration, after which it won’t appear on user's pages also if unread
▪ a destination: to a specific user or for all
- We need a page to list the posted notifications in detail
- The web application should provide a working PoC of:
- o A User settings editor
- o A way to list users and notifications entries with filters.
- o A solution to manually post new notification items.

### Instructions

- **Clone the repo & run composer install**
- **Run the migrations**
- **Run the Seeder UsersTableSeeder**
- **Run the project using php sertisan serve**

- **Login to wesite/login with email:admin@example.com and password : password**
-  Create Notifications and send them to all or specific users.
-  View the Users list and Impersonate as one.
-  As a user, On-screen notifications are based on preference and view all  notifications.

 
