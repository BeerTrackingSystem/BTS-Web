# Beer Tracking System
Track your beer consumption!
## Features
- Track spilled beer!
> Everytime someone spills beer, he/she/it gets a strike. After 5 strikes he/she/it has to buy beer for the group.

> If he/she/it gets new beer, strikes can be deleted.
- Overview of the current available beer amount!
> Don't get surprised by an empty beer stock.
- Email validation needed to add/del strikes
- Display a daily changing MotD
- Planned features are tracked in the issues section
- Veterans!
> When people are not available anymore, they can be moved to veterans
> Veterans section with login to add a visit when they are in the area
- Admin-Panel with dozens of features!
- Seperated mobile view for the basic use

**Works in general with alcohol!**

## Installation
### Requirements
- Webserver (no matter which)
- Mysql/MariaDB (else you have to rewrite the "php->mysqli-query" connects)
- PHP7
- Just a lil bit knowledge in what you are doing, but seriously it's plain html/php... you can't do much wrong

### Installation
1. Create database and database-user with grant on that database (name it yourway)
2. Edit the database name in db_strucuture.sql to your needs
3. Push the db_structure.sql file into your database. All required tables will be created
4. Configure your webserver your way and set "index.php" as index page and for /admin the admin.php as index page
5. Maybe secure the admin section, e.g. with htaccess
6. Copy all files (except .sql file) into your web-root directory
7. Modify the db.inc.php file (exchange database credentials with yours)
8. Edit generate... and validate... files and change the "echo" outputs to your needs 
9. Ofc you can exchange the favicon
10. Set up the basics on the admin panel (create user, add quote, change titles/headings)
11. Open a beer and try it out!

**Important** The reloading of the main page stops after you added the first quote

## Screenshots
![Current website view](https://image.prntscr.com/image/y1VPM7WmQQmHTgtqb8vv-A.png)

## License
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)

MDITSA/BeerTrackingSystem is licensed under the

GNU Affero General Public License v3.0
Permissions of this strongest copyleft license are conditioned on making available complete source code of licensed works and modifications, which include larger works using a licensed work, under the same license. Copyright and license notices must be preserved. Contributors provide an express grant of patent rights. When a modified version is used to provide a service over a network, the complete source code of the modified version must be made available.
