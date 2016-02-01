PWEB
============

pweb is distributed under The MIT License (see LICENSE)

Website: http://emmanuel-chambon.fr/22

/!\ WARNING
============
This is a hobby project. Use it at your own risks!

This CMS may be highly vulnerable to SQL injection, beware!

If you fear this may endanger your data, wait for version 0.2.0 which is currently on tracks. It will use a lightweight SQL framework (medoo) which should prevent SQL injection. It will also feature a homemade templating system which will allow easier personalisation and a very simple plugins system to add functionalities.
I'm also considering creating a new dev-branch based on CodeIgniter framework which is known to be quite secure.

NOTE
============
pweb is known to work with the current PHP, MySQL version.

PHP: 	5.6.11

MySQL: 	5.6.27

Most probably, PHP>=5 and MySQL>=5 is required to run pweb.

ADMIN
============
Default admin credentials:

* username: admin
* password: admin

To access the admin board: http://mydomain.com/adm/

Do not forget the last slash "/" otherwise, if your set url rewriting as in "install/url_rewriting.txt", it will try to redirect to http://mydomain.com/pub/adm.php

INSTALLATION
============
To install pweb, make sure you have root access to a MySQL database.

* create a new database;
* execute "install/db.sql" to fill this new database with the required tables;
* upload pweb source code to your webserver root directory;
* read "install/error_pages.txt" and "install/url_rewriting.txt" to set up the error pages and url rewriting accordingly (visit the official pweb website to learn how to do it if you use nginx, should be easier with apache btw.);
* delete the "install" directory from your server;
* access the admin board and change the username and password (this is CAPITAL since anyone could be reading this doc);
* Enjoy!

CHANGELOGs 
============
0.1.4
* widgEditor css content (widgContent.css) is now found and has been updated to support the website style file
* index.html favicon now routes to the correct file
* corrected apostrophe bug in /adm/index (ENT_QUOTES in htmlspecialchars)

0.1.3
* minor changes in readme
* sends an error if email is incorrectly formatted (admin board)

0.1.2

* Added github class in css to create links to github repositories
* Corrected some info in the README file
* Added viewport meta tag (header.php) to avoid automatic redimensioning on low res devices (smartphones)
* updated style.css to take low res devices into account (no more crammed things ...)
* when low-res version of the website is active, this is indicated above the article html tag

0.1.1

* MySQL queries have been completely rewritten using prepare() and bindParam()
* resulting bugs in editpage.php and editpubli.php corrected
* lighter favicons (tared code is now below 100Ko!!)
* implemented links as required by the latest url rewriting
* better accentuation support when displaying bibtex entries (acute, grave and circ for any character are now supported, contact me if you need others, this should be easier to add now!)
* ...
