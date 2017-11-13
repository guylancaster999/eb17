<?php
session_start();
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>

<script>
$(function() {
    $.post('someScript.php', { width: screen.width, height:screen.height }, function(json) {
        if(json.outcome == 'success') {
            // do something with the knowledge possibly?
        } else {
            alert('Unable to let PHP know what the screen resolution is!');
        }
    },'json');
});
</script>
<?php
print $_SESSION['screen_width'];
?>

</body>
</html>