<!-- included from includes/twitter.php -->
<div id="twitter">

</div>

<script language="JavaScript">
    $.getJSON("http://twitter.com/statuses/user_timeline.json?screen_name=bsideslondon&count=5&callback=?",
        function(data){
            $.each(data, function(i,item){
                ct = item.text;
                ct = ct.replace(/http:\/\/\S+/g,  '<a href="$&" target="_blank">$&</a>');                ct = ct.replace(/\s(@)(\w+)/g,    ' @<a href="http://twitter.com/$2" target="_blank">$2</a>');   
                ct = ct.replace(/\s(#)(\w+)/g,    ' #<a href="http://search.twitter.com/search?q=%23$2" target="_blank">$2</a>');
                $("#twitter").append('<p>'+ct +"</p>");
            });
        });
</script>
