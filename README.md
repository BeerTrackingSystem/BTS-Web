# Beer Tracking System
Track your beer consumption!
## Features
- Track spilled beer!
> Everytime someone spills beer, he/she/it gets a strike. After 5 strikes he/she/it has to buy beer for the group.

> If he/she/it gets new beer, strikes can be deleted.
- Overview of the current available beer amount!
> Don't get surprised by a empty beer stock.

**Works in general with alcohol!**

## Installation
### Requirements
- Webserver (no matter which)
- Mysql/MariaDB (else you have to rewrite the "php->mysqli-query" connects)
- PHP7
- Just a lil bit knowledge in what you are doing, but seriously it's plain html/php... you can't do much wrong

### Installation
1. Create database and database-user with grant on that database (name it yourway)
2. Modify the db_structure file (exchange database-name with yours)
3. Push the file into your database. All required tables will be created
4. Configure your webserver your way and set "index.php" as index page
5. Copy all files (except .sql file) into your web-root directory
6. Modify the db.inc.php file (exchange database credentials with yours)
7. Look through all files and change hostnames, links, titles etc. to your needs (shouldn't be that much - will be less in future, variables ftw)
8. Create user in the "user" table with name, email and if needed sms-number
9. Open a beer and try it out!

## Screenshots
![enter image description here](https://image.prntscr.com/image/6S-5VTUaR_iWvkIrVLB1HA.png)
Well... you won't see more atm... new feature are coming!
