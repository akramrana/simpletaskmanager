<p align="center">
    <h1 align="center">Simple Task Manager <br/>By<br/>Akram Hossain</h1>
    <br>
</p>

Simple task manager application best use for managing tasks for multiple user.

The project contains the 3 basic features including admin,tasks and user management.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then update this project dependency using the following command:

~~~
composer update
~~~

Now you should be able to access the application through the following URL, 
assuming `taskmanager` is the directory
directly under the Web root.

~~~
http://localhost/taskmanager/
~~~


You can then access the application through the following URL:

~~~
http://localhost/taskmanager/
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=taskmanager',
    'username' => 'root',
    'password' => '123123',
    'charset' => 'utf8',
];
```

**NOTES:**
- That project won't create the database for you, this has to be done manually before you can access it.
- Check and import the db.sql file from the `web/` directory to your MySQL Server.
