<?php

DEFINE('ROOT_DIR', __DIR__ . '/../');
DEFINE('SRC_DIR', ROOT_DIR . 'src/');

// Load the class loader.
require_once(SRC_DIR . 'NetworkPie/Bloke/Loader.php');
$loader = new \NetworkPie\Bloke\Loader(SRC_DIR);

// Create the service locator/DI and add services.
$locator = new \NetworkPie\Bloke\ServiceLocator();
require_once(ROOT_DIR . 'services.php');

// Load the routes
$router = $locator->router;
require_once(ROOT_DIR . 'routes.php');

$app = new \NetworkPie\Bloke\Application($locator);
$app->dispatch();
