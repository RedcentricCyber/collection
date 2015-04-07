<?php

// initialise our session
session_start();

// pull in our bsides libraries
include("ZeDuLcNi/authentication.php");
include("ZeDuLcNi/common.php");
include("ZeDuLcNi/config.php");
include("ZeDuLcNi/database.php");
include("ZeDuLcNi/intranet.php");

$core = new Intranet(&$redis,&$db);

// get our user id
$uid = clean_numeric($_SESSION['uid']);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated so redirect to "login"
    header("Location: " . SITE_NAME . SITE_LOGIN_PAGE);
    exit;
}

// get the challenge email address
$email_address = get_config('challenge.email_address', &$config);

// set our page title
$title = "Challenge Details";
include("ZeDuLcNi/header.php");
include("ZeDuLcNi/menu.php"); 
?>

<div id="main-content">
    <h1>The BSides London 2012 Web Hacking Challenge</h1>
    <p>Just in case you didn't screenshot the page with the challenge questions, or weren&rsquo;t running through an attack proxy at the time, here is the aim of the game.</p>
    
    <h3>The Challenge</h3>
    <p>This site is a pretend intranet site for the BSides London organisers. It turns out though that their developer isn&rsquo;t quite as good at secure coding as he should be and there a number of vulnerabilities in the web application.</p>
    <p>Your challenge is to find and exploit these vulnerabilities in order to answer the questions below.</p>
    <strong>One final point. The scope for this challenge is the web application, NOT THE INFRASTRUCTURE. There is no need to perform any kind of scanning, network or web-app based to complete this challenge. Excessive traffic will cause your IP address to be blocked. This challenge is about the <a href="#" onclick="show_lightbox('http://www.youtube.com/embed/7ww1XDReAiw'); return false;">"communidy"</a> so please play fair and in the spirit in which it is intended.</strong>

    <h3>The Questions</h3>
    <ol>
        <li>What is Matt&rsquo;s password for the Intranet?</li>
        <li>Who did Iggy meet on January 20th?</li>
        <li>What is Javvad&rsquo;s password?</li>
        <li>What is the kernel version of the underlying server?</li>
        <li>What is the SHA1 value in the file /bsides-challenge? (on the host itself, not on the website)</li>
    </ol>

    <p>When you think you have all of the answers stick them in an email (please make it obvious which answer relates to which question!) to <a href="mailto:<?php echo $email_address; ?>?subject=Challenge 4: BSidesLondon Crew secrets exposed"><?php echo $email_address; ?></a> along with your name or handle. The first correct entry will be the overall winner, the first five correct entries will all receive an entry ticket to BSides London 2012.</p>
</div>

<div id="lightbox" onclick="hide_lightbox()" class="black_background">
    <div class="white_frame">
        <iframe id="player" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
        <div class="close_button" onclick="hide_lightbox()">close</div> 
    </div>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
