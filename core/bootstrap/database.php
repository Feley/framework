<?php

use Rocket\Database\Database;

$db = new Database;

$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'voom',
    'username'  => 'root',
    'password'  => 'mysql',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$db->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$db->bootEloquent();