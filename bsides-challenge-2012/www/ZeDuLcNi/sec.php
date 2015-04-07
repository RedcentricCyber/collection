<?php

function clean_alpha($input) {
    return preg_replace("/[^a-zA-Z]+/","", $input);
}

function clean_numeric($input) {
    return preg_replace("/[^0-9]+/","", $input);
}

function clean_alphanumeric($input) {
	return preg_replace("/[^a-zA-Z0-9]+/","", $input);
}

function clean_alphanumeric_underscore($input) {
	return preg_replace("/[^a-zA-Z0-9_]+/","", $input);
}

function clean_numeric_colon($input) {
	return preg_replace("/[^0-9:]+/","", $input);
}

function clean_nonspecial($input) {
    return preg_replace("/[^a-zA-Z0-9.,\ ]+/","", $input);
}

function clean_filename($input) {
    return preg_replace("/[^a-zA-Z0-9\.\/]+/","", $input);
}

function clean_json($input) {
    return preg_replace("/[^a-zA-Z0-9\{\}:\\,\"\[\]]+/","", $input);
}

?>
