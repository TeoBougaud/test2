<?php
return [
    Http\Request::class => DI\get('Http\HttpRequest'),
    Http\Response::class => DI\get('Http\HttpResponse'),
    Http\HttpRequest::class => DI\create('Http\HttpRequest')->constructor($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER),

    Armonia\Renderer\RendererInterface::class => DI\get('Armonia\Renderer\TwigRenderer'),
    \Twig\Environment::class => function (\Psr\Container\ContainerInterface $c) {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/templates');
        $twig = new \Twig\Environment($loader);

        return $twig;
    },
    
];