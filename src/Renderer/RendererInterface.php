<?php declare(strict_types = 1);

namespace Armonia\Renderer;

interface RendererInterface
{
    public function render($template, $data = []) : string;
}