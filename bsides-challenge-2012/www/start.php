<?php

// initialise our session
session_start();

// pull in our bsides library
include("ZeDuLcNi/common.php");

// generate a random string
$str = random_string(10);

// register the random string in the session so we know you used your own ;-)
$_SESSION['str'] = $str;

// if we got to here we should be valid
$base_image = SITE_ROOT . "/assets/images/grass_roots.jpg";
$raw_image = imagecreatefromjpeg($base_image);

// define colour
$colour = imagecolorallocate($raw_image, 255, 255, 255);

// add text from $str
$output_file = "/tmp/$str";
imagestring($raw_image,5,180,180,$str,$colour);
imagejpeg($raw_image, $output_file);

// base64 encode the image
if ($fp = fopen($output_file, "r", 0)) {
	$img = fread($fp,filesize($output_file));
	fclose($fp);
	$base64_image = chunk_split(base64_encode($img));
} else {
	print "oh dang, well that didn't work";
	exit;
}

// tidy up our mess
unlink($output_file);

// set our page title
$title = "Start";
include("ZeDuLcNi/header_intro.php");

?>

<div id="container">
    <div id="main-content">
        <pre><?php echo $base64_image; ?></pre>
    </div>
</div>
<?php include("ZeDuLcNi/footer.php"); ?>
