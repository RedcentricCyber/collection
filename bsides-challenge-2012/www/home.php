<?php

// initialise our session
session_start();

// pull in our bsides libraries
include("ZeDuLcNi/authentication.php");
include("ZeDuLcNi/common.php");
include("ZeDuLcNi/config.php");
include("ZeDuLcNi/database.php");
include("ZeDuLcNi/redis.php");
include("ZeDuLcNi/intranet.php");

$core = new Intranet(&$redis,&$db);

// get our user id
$uid = clean_numeric($_SESSION['uid']);

// get the previously read items
$cookie = clean_numeric_colon($_COOKIE['recently_read']);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// set our page title
$title = "Home";
include("ZeDuLcNi/header.php");
include("ZeDuLcNi/menu.php"); 
?>

<div id="main-content">
    <h1>Welcome to the Security BSides London Intranet</h1>
    <p>This is our organiser Intranet for keeping up to date with each other about stuff prior to the each conference.</p>
    <p>It&rsquo;s not a real intranet of course so some stuff is not supposed to work, like sending messages for example. You should get an alert box telling you if something is not implemented.</p>
    <p>It&rsquo;s a typical LAMP web application written in HTML5 and CSS3 with some funky JQuery thrown in too so you'll need a decent, modern browser to take part. Personally I&rsquo;d use the latest Firefox but it&rsquo;s up to you.</p>
    <p>If you aren&rsquo;t already running through an attack proxy it&rsquo;s probably time to fire one up.</p>
    <p>If you need a reminder of the challenge details and the questions, please go click on Challenge in the main menu above at any time, or go <a href="/challenge.php">here</a>.</p>
</div>

<div id="recent">
    <h3>Recently viewed updates</h3>
    <ul>
<?php
if ($cookie != "") {
    $recent = $core->get_recent_updates($cookie); 
    foreach ($recent as $x) {
        print "<li><a href=\"/article.php?id=$x[id]\">$x[title]</a></li>";
    }
} else {
    print "<li>You haven&rsquo;t viewed anything yet</li>";
}
?>
    </ul>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
