# E-Library (MladenZeljic/library)

How to use this project:
  - Unzip this project;
  - Make sure that there is root folder "library-master" with hierarchy shown below;
  - Rename project root folder "library-master" to "project";
  - Copy or move project root folder to your server;
  - Create database 'library', preferably with croatian collation; 
  - Import library.sql from project data/database folder into it by using phpMyAdmin import;

PHP 5 >= 5.4.0 or PHP 7 is required for the correct operation of this application! 
(Because of two model classes which implement JsonSerializable interface, and because of some parts of syntax, that are not supported in earlier versions of PHP. Still it is preferable that you use the latest version of PHP just in case.)

For reviewing/testing purposes do one of the following while logging in:
  
  - to gain admin access, enter the following combination of username and password: admin pass;
  - to gain librarian access, enter the following combination of username and password: librarian pass;
  - to gain user access, enter the following combination of username and password: user pass;

Mentoned username and password combinations might still change someday in the future.

Here is the current project folder and file hierarchy:

project
├── data
|	├── data_access
|	|	├── addressDAO.php
|	|	├── authorDAO.php
|	|	├── bookDAO.php
|	|	├── book_authorDAO.php
|	|	├── book_copyDAO.php
|	|	├── book_genreDAO.php
|	|	├── book_lendDAO.php
|	|	├── categoryDAO.php
|	|	├── genreDAO.php
|	|	├── memberDAO.php
|	|	├── publisherDAO.php
|	|	├── query_interfaceDAO.php
|	|	├── roleDAO.php
| |	└── userDAO.php
|	├── data_connect
| |	└── connection.php
|	├── data_controllers
|	|	├── address_management_controller.php
|	|	├── author_management_controller.php
|	|	├── basic_controller.php
|	|	├── book_copy_management_controller.php
|	|	├── book_lendings_management_controller.php
|	|	├── book_management_controller.php
|	|	├── category_management_controller.php
|	|	├── genre_management_controller.php
|	|	├── index_controller.php
|	|	├── login_register_controller.php
|	|	├── membership_management_controller.php
|	|	├── publisher_management_controller.php
|	|	├── user_book_controller.php
|	|	├── user_management_controller.php
| |	└── user_profile_controller.php
|	├── data_helpers
| |	└── helpers.php
|	├── data_models
|	|	├── address.php
|	|	├── author.php
|	|	├── book.php
|	|	├── book_copy.php
|	|	├── category.php
|	|	├── genre.php
|	|	├── lend.php
|	|	├── membership.php
|	|	├── publisher.php
|	|	├── role.php
| |	└── user.php
| └── database
| 	└── library.sql
├── interface
| ├── pages
|	|	├── address-management.php
|	|	├── author-management.php
|	|	├── book-copy-management.php
|	|	├── book-lendings-management.php
|	|	├── book-management.php
|	|	├── category-management.php
|	|	├── genre-management.php
|	|	├── login-register.php
|	|	├── membership-management.php
|	|	├── publisher-management.php
|	|	├── user-book.php
|	|	├── user-management.php
| |	└── user-profile.php
| ├── scripts
|	|	├── js
|	|	|	├── bootstrap.bundle.js
|	|	|	├── bootstrap.bundle.js.map
|	|	|	├── bootstrap.bundle.min.js
|	|	|	├── bootstrap.bundle.min.js.map
|	|	|	├── bootstrap.js
|	|	|	├── bootstrap.js.map
|	|	|	├── bootstrap.min.js
| |	|	└── bootstrap.min.js.map
|	|	├── address-script.js
|	|	├── author-script.js
|	|	├── book-script.js
|	|	├── category-script.js
|	|	├── copy-script.js
|	|	├── genre-script.js
|	|	├── lend-script.js
|	|	├── member-script.js
|	|	├── page.js
|	|	├── publisher-script.js
|	|	├── user-book-script.js
| |	└── user-management-script.js
| └── styles
|		├── css
|		|	├── .DS_Store
|		|	├── bootstrap-grid.css
|		|	├── bootstrap-grid.css.map
|		|	├── bootstrap-grid.min.css
|		|	├── bootstrap-grid.min.css.map
|		|	├── bootstrap-reboot.css
|		|	├── bootstrap-reboot.css.map
|		|	├── bootstrap-reboot.min.css
|		|	├── bootstrap-reboot.min.css.map
|		|	├── bootstrap.css
|		|	├── bootstrap.css.map
|		|	├── bootstrap.min.css
|   |	└── bootstrap.min.css.map
|		├── author-management.css
|		├── author.css
|		├── book-lend.css
|		├── bootstrap-form-fix.css
|		├── bootstrap-nav-fix.css
|		├── bootstrap-table-fix.css
|		├── category.css
|		├── footer.css
|		├── genre.css
|		├── index.css
|		├── login-register.css
|		├── modal.css
|		├── page.css
|   └── user-profile.css
├── resources
|   └── images
|		  ├── library-bg.jpeg
|		  ├── library-icon.ico
|   	└── library-icon.png
├── README.md
└── index.php
