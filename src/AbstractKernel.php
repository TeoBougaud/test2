<?php

declare(strict_types=1);

namespace Armonia;

abstract class AbstractKernel
{

    private $container;
    private $request;
    private $response;

    public function __construct()
    {
        $this->loadEnvironment();
        $this->registerErrorHandler();
        $this->injectDependencies();
        $this->createRequestAndResponse();
        $this->dispatchRoute();
        $this->createHeaders();
    }

    public abstract function loadEnvironment();

    private function registerErrorHandler()
    {
        if (getenv('environment') !== 'production') {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
    }

    private function injectDependencies()
    {
        $builder = new \DI\ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../config/di.php');
        $this->container = $builder->build();
    }

    private function createRequestAndResponse()
    {
        $this->request = $this->container->get('Http\HttpRequest');
        $this->response = $this->container->get('Http\HttpResponse');
    }

    abstract protected function defineRoutes(): array;

    private function dispatchRoute()
    {
        $routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
            $routes = $this->defineRoutes();
            foreach ($routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        };
        
        $uri = $this->request->getUri();
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
        $routeInfo = $dispatcher->dispatch($this->request->getMethod(), $uri);
        
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // On vérifie si un ancien script portant ce nom existe
                $path = __DIR__ . '/../public/old' . $uri;
                if (file_exists($path) && is_file($path)) {
                    $this->response->setContent($this->getOldScriptContent($path));
                }
                // Sinon on affiche la classique 404
                else {
                    $this->response->setContent('404 - Page not found');
                    $this->response->setStatusCode(404);
                }
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $this->response->setContent('405 - Method not allowed');
                $this->response->setStatusCode(405);
                break;
            case \FastRoute\Dispatcher::FOUND:
                $className = $routeInfo[1][0];
                $method = $routeInfo[1][1];
                $vars = $routeInfo[2];

                $class = $this->container->get($className);
                $class->$method($vars);
                break;
        }
    }

    private function createHeaders()
    {
        foreach ($this->response->getHeaders() as $header) {
            header($header, false);
        }
    }

    public function terminate()
    {
        return $this->response->getContent();
    }

    // Pour charger les anciens scripts en attente de migration
    // On démarre un buffer et on récupère le contenu dans une string
    // On ferme le buffer à la fin de l'exécution et on renvoie son contenu
    private function getOldScriptContent($path)
    {
        ob_start();
        require($path);
        $oldResult = ob_get_contents();
        ob_end_clean();
    }
}
