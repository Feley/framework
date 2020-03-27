<?php
use Rocket\Routing\Router;


Router::get('/api/', 'SiteController@index');
Router::get('/api/test', 'SiteController@test');
Router::get('/api/about', 'SiteController@index');

