<?php

use App\Presentation\Controller\TransactionCommissionController;
use App\Presentation\ValueObject\Input;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
$loader->load('services.yaml');
$container->compile();

$controller = $container->get(TransactionCommissionController::class);
$controller->run(Input::createFromArgv($argv));

