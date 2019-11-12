<?php declare(strict_types = 1);

namespace Armonia\Controller;

use Armonia\Controller\AbstractController;

class Controller extends AbstractController
{
    public function index(): void
    {
        $data = ['name' => ''];
        $html = $this->renderer->render('index', $data);
        $this->response->setContent($html);
    }
}

