<?php

require_once("spyc.php");
$config_file = SITE_ROOT . '/config.yaml';
$config = Spyc::YAMLLoad($config_file);

function get_config($item,&$config) {
    list($k, $v) = split("\.", $item); 
    return $config[$k][$v];
}

?>
