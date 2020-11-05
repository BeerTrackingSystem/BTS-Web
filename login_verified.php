<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
        include 'db.inc.php';
?>
<?php
	$sessionid=$_COOKIE['PHPSESSID'];

	$querydelsession = "DELETE FROM auth_sessions WHERE sessionid = '$sessionid';";
	$resultdelsession = mysqli_query($db, $querydelsession);

	$queryaddsession = "INSERT INTO auth_sessions (userid, sessionid, create_date) SELECT user.id, '$sessionid', current_timestamp() FROM user WHERE user.name = '$username';";
	$resultaddsession = mysqli_query($db, $queryaddsession);

	header("Location: http://$_SERVER[HTTP_HOST]");	
?>
