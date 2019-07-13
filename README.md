# Beer Tracking System
Track your beer consumption!
## Features
- Track spilled beer!
> Everytime someone spills beer, he/she/it gets a strike. After 5 strikes he/she/it has to buy beer for the group.

> If he/she/it gets new beer, strikes can be deleted.
- Overview of the current available beer amount!
> Don't get surprised by a empty beer stock.
- Email validation needed to add/del strikes
- Planned features are tracked in the issues section

**Works in general with alcohol!**

## Installation
### Requirements
- Webserver (no matter which)
- Mysql/MariaDB (else you have to rewrite the "php->mysqli-query" connects)
- PHP7
- Just a lil bit knowledge in what you are doing, but seriously it's plain html/php... you can't do much wrong

### Installation
1. Create database and database-user with grant on that database (name it yourway)
3. Push the db_structure.sql file into your database. All required tables will be created
4. Configure your webserver your way and set "index.php" as index page and the servername to your domain from which the site will be accessable
5. Copy all files (except .sql file) into your web-root directory
6. Modify the db.inc.php file (exchange database credentials with yours)
7. Edit index.php and change titles/names according your needs
8. Edit generate... and validate... files and change the "echo" outputs to your needs 
8. Ofc you can exchange the favicon
9. Create user in the "user" table with name, email and if needed sms-number
10. Currenty there are two validations needed for a strike - If you want more validations for a strike you just have to edit the validate... files and add a new column to the "pending_strike..." tables
10. Open a beer and try it out!

## Screenshots
![Current website view](https://image.prntscr.com/image/lojgjiYkTKW2cyFA6rdvNg.png)

Well... you won't see more atm... new features are coming!
