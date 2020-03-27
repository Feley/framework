<?php
use Rocket\Routing\Router;


Router::get('/', 'SiteController@index');
Router::get('/test', 'SiteController@test');
Router::get('/about', 'SiteController@index');

