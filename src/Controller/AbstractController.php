<?php declare(strict_types = 1);

namespace Armonia\Controller;

use Http\Request;
use Http\Response;
use Armonia\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController 
{
    protected $request;
    protected $response;
    protected $renderer;
    protected $container;

    public function __construct(Request $request, Response $response, RendererInterface $renderer, ContainerInterface $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->container = $container;
    }
}