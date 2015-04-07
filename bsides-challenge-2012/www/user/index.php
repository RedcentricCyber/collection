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
$avatar_directory = get_config('profile.avatar_directory',&$config);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// set our page title
$title = "View Profile";
include("../ZeDuLcNi/header.php");

// get our uid from the session
$uid = clean_numeric($_SESSION['uid']);

if (!empty($_GET['id'])) {
    $userid = clean_numeric($_GET['id']);
} else {
    $userid = $uid;
}

$profile_fullname = $core->get_user_fullname($userid);
$results = $core->get_profile($userid);

include("../ZeDuLcNi/menu.php");
?>

<div id="main-content">
    <div id="profile">
<?php 
    if ($results['id'] != $userid) {
        print "<span class=\"error\">User id not found</span>";
    } else {
?>
        <span><strong>Name:</strong> <?php echo $profile_fullname; ?></span>
        <span><strong>Bio:</strong> <?php echo $results['bio']; ?></span>
        <img src="<?php echo $results['profile_image']; ?>" />
        <a href="https://twitter.com/<?php echo $results['twitter_handle']; ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $results['twitter_handle']; ?></a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
    }
?>
    </div>
</div>

<?php 
footer:
include("../ZeDuLcNi/footer.php"); 
?>
