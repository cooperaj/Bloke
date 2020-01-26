<?php

DEFINE('ROOT_DIR', __DIR__ . '/../../');
DEFINE('SRC_DIR', ROOT_DIR . 'src/');

// Load the class loader.
require_once(SRC_DIR . 'NetworkPie/Bloke/Loader.php');
$loader = new \NetworkPie\Bloke\Loader(SRC_DIR);
