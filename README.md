<p align="center">
    <h1 align="center">Simple Task Manager <br/>By<br/>Akram Hossain</h1>
    <br>
</p>

Simple task manager application best use for managing tasks for multiple user.

The project contains the 4 basic features including admin,tasks and user management and API endpoint for task.
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
- Check and import the `taskmanager.sql` file from the `web/` directory to your MySQL Server.


**Admin Login:**
- User ID `akram.hossain@lezasolutions.net`.
- Password `123123`

API Endpoints
-------------
### Add Task Api
Method: HTTP POST
Request URI: http://localhost/taskmanager/api/task
Request Data:
```
{
    "parent_id":"16",
    "user_id":3,
    "title":"Task Lorem 1.1",
    "points":2,
    "is_done":1,
    "email":"john.koe@email.com"
}
```
Response Data:
```
{
    "status": 201,
    "message": "success",
    "data": {
        "id": 18,
        "parent_id": "16",
        "user_id": 3,
        "title": "Task Lorem 1.1",
        "points": 2,
        "is_done": 1,
        "created_at": "2019-08-31 12:26:39",
        "updated_at": "2019-08-31 12:26:39"
    }
}
```

### Update Task Api
Method: HTTP PUT
Request URI: http://localhost/taskmanager/api/task/18
Request Data:
```
{
    "parent_id":"16",
    "user_id":3,
    "title":"Task Lorem 1.1",
    "points":3,
    "is_done":0,
    "email":"john.koe@email.com"
}
```
Response Data:
```
{
    "status": 201,
    "message": "success",
    "data": {
        "id": 18,
        "parent_id": "16",
        "user_id": 3,
        "title": "Task Lorem 1.1",
        "points": 3,
        "is_done": 0,
        "created_at": "2019-08-31 12:26:39",
        "updated_at": "2019-08-31 12:39:08"
    }
}
```