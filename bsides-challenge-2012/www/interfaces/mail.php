<?php

// initialise our session
session_start();

// pull in our bsides libraries
include("../ZeDuLcNi/authentication.php");
include("../ZeDuLcNi/common.php");
include("../ZeDuLcNi/config.php");
include("../ZeDuLcNi/redis.php");
include("../ZeDuLcNi/database.php");
include("../ZeDuLcNi/intranet.php");

$core = new Intranet(&$redis,&$db);

// get our user id - DELIBERATE BAD STUFF HERE - DIRECT OBJECT REFERENCE
$uid = clean_numeric($_SESSION['uid']);
$mailid = clean_numeric($_GET['userid']);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated - give it the old heave-ho
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

header('Content-type: application/json');

$results = $core->get_user_messages($mailid);
print "{\"messages\":";
print json_encode($results);
print "}";
?>

