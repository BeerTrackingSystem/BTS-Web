# Beer Tracking System
## Overview
BTS is a tool for tracking spilled beer, keep an eye on the current stock, rate beers and stay in touch with friends/collegues/... who maybe moved away.
## Features
- Track spilled beer!
    > - Everytime someone spills beer, he/she/it gets a strike (amount customizable). 
    > - Wedding? 50th Bday? Special events getting a special amount of strikes.

- Track the date when someone brought beer
    > Important as soon as the stock goes empty and it's up to decide who has to refill

- Track the current stock
    > Don't get surprised by an empty beer stock.

- Email validation needed to add/del strikes
    > That's a serious business, you don't joke about beer! Strikes and Deletions have to be verified by the others!

- Get motivated to drink a beer by reading the Message of the Day
    > Add custom quotes which automatically change daily.

- Veterans!
    > Stay in touch with friends and others and get notified when they are in your area!

- Admin-Panel with dozens of features
    > You can edit/modify basically everything!

- Seperated mobile view for the basic use
    > Fewer views so you get the essential informations on the go.

**Doesn't have to be beer! Works in general with alcohol!**

## Installation
### Requirements
- Webserver (no matter which)
- Mysql/MariaDB (else you have to rewrite ally "php->mysqli" queries)
- PHP7 (8 not tested yet)
- Just a lil bit knowledge in what you are doing, but it's plain html/php/javascript...

### Tasks
1. Create a database and database-user with grant on that database (name it yourway)
2. Save database credentials in db.inc.php
3. Set "event_scheduler=on" in mysql/mariadb serverconfig - else the áuthorized session cleanup won't work
4. Push the db_X.0_structure.sql file into your database. All required tables will be created
5. Push the db_X.0_values.sql file into your database. All basic values will be inserted. You may edit the values before you insert them, otherwise you can set them later on the admin panel
6. Configure your webserver and set index:
    - main page = index.php
    - ranking page = ranking/index.php
    - admin page = admin/admin.php
    - api page = api/api.php
7. Secure the admin section, e.g. with htaccess!
8. Copy all files (except .sql files) into your web-root directory
9. You may remove the "Support Me" button, but not modify it!
10. Edit generate... and validate... files and change the "echo" outputs to your needs
11. You may change the favicon!
12. Set up the basics on the admin panel (create user, add quote, change titles/headings, add breweries/beers)
13. Open a beer and try it out!

## Update
1. Backup directory and database
2. Unzip new files in the directory
3. If there are database changes, i'll supply a "db_update_X.X-X.X.sql" file. Push the needed file into your database. Check your current version either on the top/left of the main page or look it up in the misc table
4. Open a beer and try it out!

## Screenshots
![Main page](https://imgur.com/8iO5YbP.png)
![Ranking page](https://imgur.com/N1zA0ED.png)
![Admin panel](https://imgur.com/IHE4uOu.png)

## License
[![License: AGPL v3](https://img.shields.io/badge/License-AGPL%20v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)

MDITSA/BeerTrackingSystem is licensed under the

GNU Affero General Public License v3.0
Permissions of this strongest copyleft license are conditioned on making available complete source code of licensed works and modifications, which include larger works using a licensed work, under the same license. Copyright and license notices must be preserved. Contributors provide an express grant of patent rights. When a modified version is used to provide a service over a network, the complete source code of the modified version must be made available.