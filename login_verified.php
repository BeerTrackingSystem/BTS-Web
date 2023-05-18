<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
        include 'db.inc.php';
?>
<?php
	$sessionid=$_COOKIE['PHPSESSID'];

	$querydelsession = "DELETE FROM auth_sessions WHERE sessionid = ?;";
	$prepdelsession = mysqli_prepare($db, $querydelsession);
	mysqli_stmt_bind_param ($prepdelsession, 's', $sessionid);
	mysqli_stmt_execute($prepdelsession);
	$resultdelsession = mysqli_stmt_get_result($prepdelsession);

	$queryaddsession = "INSERT INTO auth_sessions (userid, sessionid, create_date) SELECT user.id, ?, current_timestamp() FROM user WHERE user.name = ?;";
	$prepaddsession = mysqli_prepare($db, $queryaddsession);
	mysqli_stmt_bind_param ($prepaddsession, 'ss', $sessionid, $username);
	mysqli_stmt_execute($prepaddsession);
	$resultaddsession = mysqli_stmt_get_result($prepaddsession);

	header("Location: http://$_SERVER[HTTP_HOST]");	
?>
