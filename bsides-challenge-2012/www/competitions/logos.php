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
$upload_directory = get_config('profile.avatar_directory',&$config);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// set our page title
$title = "Logo Competition";
include("../ZeDuLcNi/header.php");

// get our uid from the session
$uid = clean_numeric($_SESSION['uid']);

$profile_fullname = $core->get_user_fullname($uid);

include("../ZeDuLcNi/menu.php");

$images = array('1330642810.jpg', '1330642874.jpg', '1330642918.jpg', '1330642930.jpg', '1330642940.jpg');
?>

<div id="main-content">
    <div id="competition">
        <h1>Logo Competition</h1>
        <p>Submissions so far, thought I&rsquo;d upload them here before they go on the public wiki. They&rsquo;re looking great!</p>
<?php
    foreach ($images as $i) {
        print "<img src=\"/uploads/images/$i\" alt=\"BSides London 2012 Logo Submission\" />";
    }
?>
    </div>
</div>

<?php 
footer:
include("../ZeDuLcNi/footer.php"); 
?>
