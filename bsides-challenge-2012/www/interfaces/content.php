<?php

// initialise our session
session_start();

// pull in our bsides libraries
include("../ZeDuLcNi/authentication.php");
include("../ZeDuLcNi/common.php");
include("../ZeDuLcNi/config.php");

$uid = clean_numeric($_SESSION['uid']);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
}

// so, here it is. game over.
$request = clean_filename($_GET['go']);

// now we have to be a little bit sensible here. you can only include the twitter php
// and image from the uploads/images directory.  otherwise it'd be too easy
if ($request == "twitter.php") {
    include(SITE_ROOT . "/includes/twitter.php");
} elseif (preg_match('|^\.\./uploads/images/\w+\.jpg$|', $request)) {
    include(SITE_ROOT . "/includes/" . "$request");
} else {
    echo "error: cannot include";
}

?>
