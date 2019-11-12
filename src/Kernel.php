<?php declare(strict_types = 1);

namespace Armonia;

use Armonia\AbstractKernel;
use Dotenv\Dotenv;

class Kernel extends AbstractKernel
{
    public function loadEnvironment()
    {
        $dotenv = Dotenv::create(__DIR__.'/../config');
        $dotenv->load();
    }


    public function defineRoutes(): array
    {
        return [
            ['GET', '/', ['Armonia\Controller\Controller', 'index']],
        ];
    }
}

