<?php

// initialise our session
session_start();

include("ZeDuLcNi/common.php");

$_SESSION = array();
session_destroy();
setcookie('PHPSESSID', '');
setcookie('recently_read', '');
header("Location: " . SITE_NAME . SITE_LOGIN_PAGE . "?msg=loggedout");

?>
