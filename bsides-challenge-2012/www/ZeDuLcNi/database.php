<?php

$db_username = get_config('database.username', $config);
$db_password = get_config('database.password', $config);
$db_name = get_config('database.dbname', $config);
$db_host = get_config('database.hostname', $config);

$db = new PDO("mysql:host=$db_host;dbname=$db_name", "$db_username", "$db_password");

?>
