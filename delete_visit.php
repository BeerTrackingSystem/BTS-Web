<?php
if (empty($_POST['id']))
{
	http_response_code(404);
	die();
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
