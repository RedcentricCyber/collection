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

$uid = clean_numeric($_SESSION['uid']);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// set our page title
$title = "Latest News";
include("ZeDuLcNi/header.php");

?>

<?php include("ZeDuLcNi/menu.php"); ?>

<div id="main-content">
    <h1>Latest news</h1>
    <div id="updates">
        <div class="heading"><span class="date">Date</span><span class="title">Title</span></div>
    <?php
        $results = $core->get_updates();
        $counter = 0;
        foreach ($results as $x) {

    ?>
    <div class="row<?php echo ($counter++ % 2 == 0) ? ' alternate' : ''; ?>"><span class="date"><?php echo $x['date']; ?></span><span class="title"><a href="article.php?id=<?php echo $x['id']; ?>"><?php echo $x['title']; ?></a></span></div>
    <?php
        }
    ?>
    </div>
</div>

<div id="right_column">
    <h3>Latest tweets</h3>
    <div id="twitter">
        <script type="text/javascript">
            $("#twitter").load("/interfaces/content.php?go=twitter.php");
        </script>
    </div>
    <a href="https://twitter.com/bsideslondon" class="twitter-follow-button" data-show-count="false">Follow @bsideslondon</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
