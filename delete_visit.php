<?php
if (empty($_POST['id']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);	
	$sessionid=$_COOKIE['PHPSESSID'];
        include 'db.inc.php';
?>

<?php
        $userid = check_login($sessionid)[2];
	include 'delvisit.php';
?>
