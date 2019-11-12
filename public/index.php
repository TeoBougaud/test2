<?php declare(strict_types = 1); 

use Armonia\Kernel;

require __DIR__.'/../vendor/autoload.php';

$kernel = new Kernel();
echo $kernel->terminate();