<?php


namespace Voom\Config;

//use League\Flysytem\Adapter\Local;
//use League\Flysytem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Laminas\Diactoros\ServerRequestFactory;
use eftec\bladeone\BladeOne;
use Rocket\Routing\Router;

class App
{
	public function run(Request $request)
	{
		//$path = new Local(_DIR_.'/../app');
		//$filesystem = new Filesystem($path);
		//load the .env
		$path = __DIR__.'/../';
		$dotenv = \Dotenv\Dotenv::createMutable($path);
        $dotenv->load();
		\Rocket\Config\Env::load($path);
		// Start the routing
		//$content = Router::start();

		$content = Router::startNow();
		return Response::create($content)->send();
	}
}
?>