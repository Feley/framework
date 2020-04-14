<?php

namespace Voom\Config;

//use League\Flysytem\Adapter\Local;
//use League\Flysytem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Rocket\Routing\Router;

class App
{
	public function run(Request $request)
	{
		//$path = new Local(_DIR_.'/../app');
		//$filesystem = new Filesystem($path);
		//load the .env
		$path = __DIR__.'/../';
		$directory = $path.'bootstrap/';
		\Rocket\Config\Env::load($path);
		$content = Router::startNow();
		$loader = new \Rocket\Foundation\Loaders\PhpLoader();
 		$loader->addDirectory($directory);
  		//s$loader->excludeDirectory('app/exclude');
  		$loader->register();
		return Response::create($content)->send();
	}
}
?>