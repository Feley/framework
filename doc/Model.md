## Illuminate Database

The Illuminate Database component is a full database toolkit for PHP, providing an expressive query builder, ActiveRecord style ORM, and schema builder. It currently supports MySQL, Postgres, SQL Server, and SQLite. It also serves as the database layer of the Laravel PHP framework.

### Usage Instructions

First, create a new "Capsule" manager instance. Capsule aims to make configuring the library for usage outside of the Laravel framework as easy as possible.

```PHP
use Rocket\Database\Database;

$db = new Database;

$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'database',
    'username'  => 'root',
    'password'  => 'password',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$db->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$db->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
//$db->bootEloquent();
```

> `composer require "illuminate/events"` required when you need to use observers with Eloquent.

Once the Database instance has been registered. You may use it like so:

**Using The Query Builder**

```PHP
$users = Database::table('users')->where('votes', '>', 100)->get();
```
Other core methods may be accessed directly from the Database in the same manner as from the DB facade:
```PHP
$results = Database::select('select * from users where id = ?', [1]);
```

**Using The Schema Builder**

```PHP
Rocket\Database\Migration;
Migration::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('email')->unique();
    $table->timestamps();
});
```

**Using The Eloquent ORM**

```PHP
class User extends Rocket\Database\Model {

}

$users = User::where('votes', '>', 1)->get();
```

For further documentation on using the various database facilities this library provides, consult the [Laravel framework documentation](https://laravel.com/docs).
