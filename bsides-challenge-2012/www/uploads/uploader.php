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
$auth = new Auth($db);

$uid = clean_numeric($_SESSION['uid']);
$role_id = clean_numeric($_SESSION['role_id']);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// check authorisation
$required_permission_name = 'ACCESS_ADMIN_PAGE';
$authorised = $auth->check_permissions_by_name($role_id, $required_permission_name);


// set our page title
$title = "Uploads";
include("../ZeDuLcNi/header_upload.php");
include("../ZeDuLcNi/menu.php"); ?>

<div id="main-content">
<?php
if (!$authorised) {
    print "<span class=\"error\">Not authorised to view this page</span>";
} else {
    print <<<END
    <h1>Image Uploader</h1>
    <div id="dropbox">
        <span class="result"></span>
        <span class="message">Drop files here to upload</span>
    </div>

    <script src="/assets/js/jquery.filedrop.js"></script>
    <script src="/assets/js/upload.js"></script>
</div>
END;
}

include("../ZeDuLcNi/footer.php"); 
?> 
