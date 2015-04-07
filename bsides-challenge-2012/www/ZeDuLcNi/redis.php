<?php

require 'Predis/Autoloader.php';
Predis\Autoloader::register();

// create a redis handle
$redis = new Predis\Client('tcp://127.0.0.1:6379');

?>

