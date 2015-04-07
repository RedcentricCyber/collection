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

// where do we put the uploaded images?
$upload_directory = get_config('uploads.directory',&$config);

// who are we?
$uid = clean_numeric($_SESSION['uid']);
$role_id = clean_numeric($_SESSION['role_id']);

// check authorisation
$required_permission_name = 'ACCESS_ADMIN_PAGE';
$authorised = $auth->check_permissions_by_name($role_id, $required_permission_name);

// check we have a valid login and redirect to login page if not
if (is_null($_SESSION['authenticated'])) {
    // not authenticated - give it the old heave-ho
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

function exit_status($str) {
    echo json_encode(array('status'=>$str));
    exit;
}

if (!$authorised) {
    print "<span class=\"error\">Not authorised to view this page</span>";
} else {
    if ($_FILES["file_upload"]["size"] != 0) {
        $user_file_name = $_FILES["file_upload"]["name"];
        $user_file_tmp = $_FILES["file_upload"]["tmp_name"];
        $user_file_size = $_FILES["file_upload"]["size"];
        $file_name = $core->generate_filename();
        $file_path = "/" . $upload_directory . "/" . $file_name;
        $target_file_name = SITE_ROOT . $file_path;
        
        if ($_FILES["file_upload"]["type"] == "image/jpeg") {
            if (getimagesize($_FILES["file_upload"]["tmp_name"])) { 
                if (move_uploaded_file($_FILES["file_upload"]["tmp_name"],$target_file_name)) {
                    exit_status("File uploaded successfully to $file_path");
                } else {
                    exit_status("Eek, something went wrong with your image upload - are you up to something naughty?");
                }
            } else {
                exit_status("Nice idea but it actually has to be an image");
            }
        } else {
            exit_status("Invalid file type. We only support JPEG");
        }
    } else {
        exit_status("You didn&rsquo;t specify a file to upload. Try again");
    }
}

include("../ZeDuLcNi/footer.php");
?>
