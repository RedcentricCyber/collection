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
require_once("../ZeDuLcNi/mobile_device_detect.php");

$core = new Intranet(&$redis,&$db);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
}

mobile_device_detect(true,true,true,true,true,true,true,SITE_NAME . "/mobi/user/mail.php",false);

// get our uid
$uid = clean_numeric($_SESSION['uid']);

// set our page title
$title = "Mail";
include("../ZeDuLcNi/header.php");
include("../ZeDuLcNi/menu.php");
?>

<div id="main-content">
    <h1 class="mail">Your messages</h1>
    <a class="mail" href="#" onclick="alert('not implemented')" title="Compose new message">Compose<img src="/assets/images/mail.jpg" alt="mail icon" /></a>
    <div id="mail">
        <div class="heading">
            <span class="from">From</span>
            <span class="date">Date</span>
            <span class="title">Subject</span>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // fetch messages from JSON interface
    var url='/interfaces/mail.php';
    var altrow = false;
    var altclass = '';
    $.getJSON(url,'userid=<?php echo $uid; ?>', function(json) {
        $.each(json.messages, function(i, post) {
            if (altrow == true) {
                var html='<div class="row alternate">';
                altrow = false;
            } else {
                var html='<div class="row">';
                altrow = true;
            }

            html+='<span class="from"><a href="/user/?id=' + post.msg_from_id + '">' + post.from + '</a></span>';
            html+='<span class="date">' + post.date + '</span>';
            html+='<a href="#" class="toggle">' + post.title + '</a>';
            html+='<div class="msgpane" style="display: none"><p>' + post.body + '</p><span><a href="#" onclick="alert(\'not implemented\')">Reply</a><a href="#" onclick="alert(\'not implemented\')">Delete</a></span></div>';
            html+='</div>';
            $("#mail").append(html);
        });
    });

    // show/hide message
    $('#mail').on('click', 'a.toggle', function() {
        $(this).next('div.msgpane').toggle('fast');
        return false;
    });
});
</script>

<?php include("../ZeDuLcNi/footer.php"); ?>
