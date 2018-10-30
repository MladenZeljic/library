# E-Library (MladenZeljic/library)

How to use this project:
  - Unzip this project. 
  - Make sure that there is root folder called "library-master" immediately followed by other subfolders and files contained in this 
    project like "data", "interface", "index.php" etc.
  - If there is another subfolder named "library-master", move its contents to project root folder and then remove it.
  - Rename project root folder "library-master" to "project". 
  - Copy or move project root folder to your server.
  - Create database 'library', preferably with croatian collation. 
  - Import library.sql from project data/database folder into it by using phpMyAdmin import.

PHP 5 >= 5.4.0 or PHP 7 is required for the correct operation of this application! 
(Because of two model classes which implement JsonSerializable interface, and because of some parts of syntax, that are not supported in earlier versions of PHP. Still it is preferable that you use the latest version of PHP just in case.)

For reviewing/testing purposes do one of the following while logging in:
  
  -to gain admin access, enter the following combination of username and password: admin pass;
  -to gain librarian access, enter the following combination of username and password: librarian pass;
  -to gain user access, enter the following combination of username and password: user pass;

Mentoned username and password combinations might still change someday in the future.
