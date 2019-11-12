<?php declare(strict_types = 1);

namespace Armonia\Renderer;

use Twig_Environment;

class TwigRenderer implements RendererInterface
{
    private $renderer;

    public function __construct(Twig_Environment $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render($template, $data = []) : string
    {
        return $this->renderer->render("$template.html.twig", $data);
    }
}