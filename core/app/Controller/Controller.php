<?php

namespace Voom\Controller;

use Rocket\Controller\WebController;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * Controller Class
 */
class Controller extends WebController
{
//         /**
//      * Controller.
//      *
//      * @param \Psr\Http\Message\ServerRequestInterface $request
//      *
//      * @return \Psr\Http\Message\ResponseInterface
//      */
//     public function __invoke(ServerRequestInterface $request) : ResponseInterface
//     {
//         $response = new Response;

//         $response->getBody()->write($body);
//         $this->$views = getenv('BASE_PATH').getenv('BLADE_VIEW');;
//         $this->$cache = getenv('BASE_PATH').getenv('BLADE_CACHE');;
//         $blade = new BladeOne($views, $cache, BladeOne::MODE_FAST);
//         $blade->setIsCompiled(false); 
//         $content = $blade->run($view, $variables);
//         return $response->withStatus(200);
//     }
}