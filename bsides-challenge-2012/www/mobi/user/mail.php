<?php

ini_set('display_errors', 1);

// initialise our session
session_start();

// pull in our bsides libraries
include("../../ZeDuLcNi/authentication.php");
include("../../ZeDuLcNi/common.php");

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
}

// set our page title
$title = "Mobile Mail";
include("../../ZeDuLcNi/header.php");

try {
    fopen("config.yaml", "r");
} catch (Exception $e) {
    echo "Caught exception: ", $e->getMessage();
}

?>
