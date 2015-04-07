<?php

include("sec.php");

// define some constants
define("SITE_NAME", "http://hive.securitybsides.org.uk");
define("SITE_ROOT", "/var/www/bsides");
define("SITE_TITLE", "Security BSides London Challenge 2012 > ");
define("SITE_LOGIN_PAGE", "/login.php");

// set our include path
$path = SITE_ROOT . "/includes";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

// generate a random string - pass it the length baby
function random_string($length) {
	// borrowed from http://www.lateralcode.com/creating-a-random-string-with-php/
	$charset = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789";
	
	$size = strlen($charset);
	$str = "";
	for ($i = 0; $i < $length; $i++) {
		$str .= $charset[rand( 0, $size - 1 )];
	}
	return $str;
}

// validate session
function valid_session($str) {
	if (empty($str) || ($_SESSION['str'] != "$str")) {
		return false;
	} else {
		return true;
	}
}

// validate source
function valid_source($source, $correct_source) {
	if (empty($source) || ($source != $correct_source)) {
		return false;
	} else {
		return true;
	}
}

// print naughty boy message
function print_naughty() {
    include("ZeDuLcNi/header_intro.php");
	print "<p>Some pages can&rsquo;t be accessed directly, that&rsquo;s naughty. Go back from where you came from.</p>";
    include("ZeDuLcNi/footer.php");
}

?>
