<?php

// initialise our session
session_start();
$source = $_SESSION['source'];

// pull in our bsides library
include("ZeDuLcNi/common.php");
include("ZeDuLcNi/config.php");

if (!valid_source($source, 'progress')) {
	print_naughty();
	exit;
}

// get the challenge email address
$email_address = get_config('challenge.email_address', &$config);

// get the challenge closing date
$closing_date = get_config('challenge.closing_date', &$config);



// set our page title
$title = "OK, Bring it";
include("ZeDuLcNi/header_intro.php");
?>

<div id="container">
    <div id="main-content" class="robot">
        <h1>OK, so it looks like you&rsquo;re not a robot</h1>
        <p>That was all fun, hopefully, but now you&rsquo;ve got a few questions to answer. BTW you won&rsquo;t have to go back through that stage again, you can bookmark the next page and access the intranet site freely, that was just an elaborate robots.txt.</p>
        <h3>The Challenge</h3>
        <p>This site is a pretend intranet for the BSides London organisers. It turns out though that their developer isn&rsquo;t quite as good at secure coding as he should be and there a number of vulnerabilities in the web application.</p>
        <p>Your challenge is to find and exploit these vulnerabilities in order to answer the questions below.</p>
        <strong>One final point. The scope for this challenge is the web application, NOT THE INFRASTRUCTURE. There is no need to perform any kind of scanning, network or web-app based, to complete this challenge. Excessive traffic will cause your IP address to be blocked. This challenge is about the "communidy" so please play fair and in the spirit in which it is intended.</strong>

        <h3>The Questions</h3>
        <ol>
            <li>What is Matt&rsquo;s password for the Intranet?</li>
            <li>Who did Iggy meet on January 20th?</li>
            <li>What is Javvad&rsquo;s password?</li>
            <li>What is the kernel version of the underlying server?</li>
            <li>What is the SHA1 value in the file /bsides-challenge? (on the host itself, not on the website)</li>
        </ol>

        <p>When you think you have all of the answers stick them in an email (please make it obvious which answer relates to which question!) to <a href="mailto:<?php echo $email_address; ?>?subject=Challenge 4: BSidesLondon Crew secrets exposed"><?php echo $email_address; ?></a> along with your name or handle. The first correct entry will be the overall winner, the first five correct entries will all receive an entry ticket to BSides London 2012.</p>

        <!-- it is sooo wrong to use javascript just to provide a link....but i don't have to be right on this site :-) -->
        <button type="submit" class="start" onclick="document.location='<?php echo SITE_LOGIN_PAGE; ?>';">GET STARTED</button>
    </div>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
