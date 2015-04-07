<?php

// pull in our bsides library
include("ZeDuLcNi/common.php");

// set our page title
$title = "Welcome";
include("ZeDuLcNi/header_intro.php");

?>

<div id="container">
    <div id="main-content">
        <img src="/assets/images/BsidesAprilLogo.jpg" alt="BSides London logo" />
        <h1>Welcome to the Security BSides London 2012 Web Hacking Challenge</h1>
        <p>This website is deliberately vulnerable to a number of common vulnerabilities and misconfigurations. Your job is to exploit them in order to answer a series of questions.</p>
        <p>The trick to the challenge will be combining a number of <a href="https://www.owasp.org/index.php/Top_10_2010-Main" target="_blank" title="Open OWASP site in a new window">OWASP Top Ten</a> vulnerabilities in order to access the data you need. Some lateral thinking will (hopefully) be required to answer all questions and you won&rsquo;t need to brute force <em>anything</em>.</p> 
        <p>And don&rsquo;t forget, the first to send in the correct answers wins a ticket to 44Con!</p>
        <button onclick="document.location='start.php';">START</button>
    </div>
    <div id="obligatory_sponsor_logo">
        <p>Challenge developed by <a href="https://twitter.com/marcwickenden" target="_blank" title="See wicky&rsquo;s tweets (in a new window)">@marcwickenden</a> and sponsored by:</p>
        <a href="http://www.44con.com/" title="44Con (opens in new windows)" target="_blank"><img src="/assets/images/bsideslondon_44con.jpg" alt="44Con logo" /></a>
        <a href="http://www.7elements.co.uk/" title="7 Elements Security Consultancy (opens in new window)" target="_blank"><img src="/assets/images/7E_logo.jpg" alt="7 Elements logo" /></a>
    </div>
</div>

<?php include("ZeDuLcNi/footer.php"); ?>
