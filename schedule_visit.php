<?php
if (!isset($_POST['visitnotice']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
	include 'check_login.php';
	$sessionid=$_COOKIE['PHPSESSID'];
?>
<?php
	$userid = check_login($sessionid)[2];

	include 'addvisit.php';
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
