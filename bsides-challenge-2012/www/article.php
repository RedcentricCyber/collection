<?php

// initialise our session
session_start();

// pull in our bsides libraries
include("ZeDuLcNi/authentication.php");
include("ZeDuLcNi/common.php");
include("ZeDuLcNi/config.php");
include("ZeDuLcNi/redis.php");
include("ZeDuLcNi/database.php");
include("ZeDuLcNi/intranet.php");

$core = new Intranet(&$redis,&$db);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// get our uid
$uid = $_SESSION['uid'];

// set our page title
$title = SITE_TITLE . "Updates";
include("ZeDuLcNi/header.php");
include("ZeDuLcNi/menu.php");

// deliberate sqli - don't laugh, you see this a lot!
$id = $_GET['id'];

// get the previously read items
$cookie = clean_numeric_colon($_COOKIE['recently_read']);
$cookie_numbers = preg_replace("/:/", "", $cookie);

// let's mess with the sqlmap people
// change your User-Agent or do it manually?
$pattern = '/^sqlmap/';
if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT'])) {
    print "<p>woh, cool, sqlmap.</p>";
    include("ZeDuLcNi/footer.php");
    exit;
}

print "<div id=\"main-content\">";
print " <div id=\"article\">";

$x = $core->get_article($id);
// get the next id - but only if it's a number, let those sqli peeps be
if (preg_match("/^[0-9]+$/", $id)) {
    $next_id = $core->get_next_article_id($id);
} else {
    $next_id = null;
}

// check for EE
if ($cookie_numbers == "425369646573") {
?>
    <h1>Easter Egg :: @dive_monkey keeping fit</h1>
    <p>We may have been in Switzerland for a con but that didn&rsquo;t stop Matt keeping in shape while we were back at the hotel.</p>
    <video width="640" height="360" autoplay controls tabindex="0">
      <source src="/assets/video/matt_summers_pressups.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
      <source src="/assets/video/matt_summers_pressups.webm" type='video/webm; codecs="vp8, vorbis"' />
      What the? Your browser does not support the HTML5 video tag.
    </video>
<?php
} else {
    // print out the article
    print "<h3>$x[title]</h3>";
    print "<span class=\"date\">$x[date]</span>";
    print "<span>$x[text]</span>";
}

// update the cookie
$core->push_update_cookie($cookie, $id);

    print "<a href=\"/updates.php\" class=\"nav\">Up</a>";
if (!is_null($next_id)) {
    print "<a href=\"article.php?id=$next_id\" class=\"nav\">Next &gt&gt</a>";
}
?>
    </div>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
