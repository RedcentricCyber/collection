<div id="menu">
    <ul id="main">
        <li class="title">BSides London Intranet</li>
        <li><a href="/home.php">Home</a></li>
        <li><a href="/updates.php">Latest news</a></li>
        <li><a href="/competitions/logos.php">Competitions</a></li>
        <li><a href="/challenge.php">Challenge</a></li>
    </ul>
<?php
if ($_SESSION['authenticated']) {
?>
    <ul id="profile">
<?php
        $fullname = $core->get_user_fullname($uid);
        echo "<li><a href=\"/user\">&#9662; $fullname</a>";
?>
            <ul>
                <li><a href="/user/mail.php">Messages</a></li>
                <?php if (clean_numeric($_SESSION['role_id']) >= 500) {
                    print "<li><a href=\"/uploads/uploader.php\">Image Uploader</a></li>";
                }
                ?>
                <li><a href="/logout.php">Log out</a></li>
            </ul>
        </li>
    </ul>
<?php
}
?>
</div>
<img class="workspace" src="/assets/images/bsides_london_50.jpg" alt="BSides London logo">
<div id="container">
