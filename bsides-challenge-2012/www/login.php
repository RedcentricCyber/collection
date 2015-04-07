<?php

// initialise and clear out our session
session_start();

// clear out the recently read cookie
setcookie('recently_read', '');

// pull in our bsides libraries
include("ZeDuLcNi/common.php");
include("ZeDuLcNi/config.php");
include("ZeDuLcNi/database.php");
include("ZeDuLcNi/authentication.php");

// create new Auth class
$auth = new Auth($db);

// lookup the encryption key
$key = get_config('encryption.key', &$config);

// set our page title
$title = "Login";
include("ZeDuLcNi/header_intro.php");

// process any msg we need to display
// currently only handles log out message
switch (clean_alphanumeric($_GET['msg'])) {
    case "loggedout":
        $info_msg = "You have been logged out";
        break;

    default:
        $info_msg = null;
}

// function to print login form
function print_login_form($info_msg, $error_msg = null) {
    print <<<END
<div id="container">
    <div id="main-content">
        <img src="/assets/images/BsidesAprilLogo.jpg" alt="BSides London logo" />
<!-- 
TODO: remove developer comments from source code.
details for testing site: username matt, password pressups
-->
END;
        print "<form method=\"post\" autocomplete=\"off\" action=\"" . SITE_NAME . SITE_LOGIN_PAGE . "\">";
        print <<<END
        <h2>Intranet Login</h2>
            <fieldset>
                <label for="username">Username</label>
                    <input type="text" name="username" id="username" required autofocus>
                <label for="password">Password</label> 
                    <input type="password" name="password" id="password" required> 
            </fieldset>
            <fieldset>
END;
        // Inform user of error
        if (isset($error_msg)) {
            print "<span class=\"error\">$error_msg</span>";
        }

        // Display informational message. Currently only used for logged out.
        if (isset($info_msg)) {
            print "<span class=\"info\">$info_msg</span>";
        }

        print <<<END
                <button type="submit">LOGIN</button>
            </fieldset>
        </form>
END;

}

// see if we were sent a username or password
if (isset($_POST['username']) || isset($_POST['password'])) {
    $username = clean_alphanumeric($_POST['username']);
    $password = clean_alphanumeric_underscore($_POST['password']);

    // set a counter
    if (isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] += 1;
    } else {
        $_SESSION['login_attempts'] = 1;
    }

    // validate the passed credentials
    if ($uid = $auth->check_login($username, $password, $key)) {
        $role_id = $auth->get_role($uid);
        // login succeeded - update session and redirect to home page
        $_SESSION['authenticated'] = true;
        $_SESSION['uid'] = $uid;
        $_SESSION['role_id'] = $role_id;
        unset($_SESSION['login_attempts']);
        $url = SITE_NAME . "/home.php";
        header("Location: $url");
        exit;       
    } else {
        if ($_SESSION['login_attempts'] >= 10) {
            // login failed - remind people brute force is not necessary
            print_login_form(null,"More than 10 failures. Remember you don&rsquo;t need to brute force");
        } else {
            // login failed - print login page again with error message
            print_login_form(null,"Login failed");
        }
    }
} else {
    // we weren't posted to so print the login form
    print_login_form($info_msg, null);
}
?>
    </div>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
