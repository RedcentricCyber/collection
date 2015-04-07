<?php

// initialise our session
session_start();

// pull in our bsides library
include("ZeDuLcNi/common.php");

// set our page title
$title = "Progress";
include("ZeDuLcNi/header_intro.php");

function print_form($error_msg = null) {
    print <<<END
    <div id="main-content">
        <img src="/assets/images/BsidesAprilLogo.jpg" alt="BSides London logo" />
        <form id="progress" method="post" action="" autocomplete="off">
            <fieldset>
                <label for="code">Enter the code you received here:</label>    
                <input type="text" name="code" id="post" required autofocus />
            </fieldset>
            <fieldset>
                <button type="submit">ENTER</button>
END;

    if (isset($error_msg)) {
        print "<span class=\"error\">$error_msg</span>";
    }

        print <<<END
            </fieldset>
        </form>
END;
}


// if we've got a POST'ed code var we do stuff
if (isset($_POST['code'])) {
    // practice what we preach :-)
    $submitted_code = clean_alphanumeric($_POST['code']);
    $session_code = $_SESSION['str'];

    if ($submitted_code === $session_code) {
        $_SESSION['source'] = 'progress';
        header("BSides: FTW");
        header("Location: " . SITE_NAME . "/okbringit.php");
    } else {
        print "<div id=\"container\">";
        print_form($error_msg = "The code entered does not match the one saved in your session from the previous step. Typing error or taken too long? <a href=\"start.php\">Try again</a>");
        print "</div>";
        
    }
} else {
    // otherwise we print the form out
    print "<div id=\"container\">";
    print_form();
    print "</div>";
    include("ZeDuLcNi/footer.php");
}

?>
