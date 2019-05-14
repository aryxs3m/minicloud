# minicloud
Minimal, web-based private file host.

STILL UNDER DEVELOPMENT, DO NOT USE IN PRODUCTION!

## What is this?
A private file manager with a PHP interface, that is similar to ownCloud/NextCloud but very lightweight and simple. Just the basics!
 - File system based (all files are stored on disk in folders)
 - Multi-user (credentials stored in MySQL database)
 - Easy integration (Samba, FTP, HTTP)
 - Responsive web interface (Bootstrap)
 
 ## How to install?
  - Put files in webserver root
  - Import install/minicloud.sql to MySQL
  - Create a directory for the user's files, and give permissions to www user
  - Edit config.inc.php
  - Log in with admin:admin
