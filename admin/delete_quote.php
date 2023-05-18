<?php
if (empty($_POST['quoteid']))
{
	http_response_code(404);
	die();
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$quoteid = $_POST['quoteid'];

	$querydelmotdquote = "DELETE FROM motd WHERE quoteid = ?;";
	$prepdelmotdquote = mysqli_prepare($db, $querydelmotdquote);
	mysqli_stmt_bind_param ($prepdelmotdquote, 'i', $quoteid);
	mysqli_stmt_execute($prepdelmotdquote);
	$resultdelmotdquote = mysqli_stmt_get_result($prepdelmotdquote);

	$querydeletequote = "DELETE FROM quotes WHERE id = ?;";
	$prepdeletequote = mysqli_prepare($db, $querydeletequote);
	mysqli_stmt_bind_param ($prepdeletequote, 'i', $quoteid);
	mysqli_stmt_execute($prepdeletequote);
	$resultdeletequote = mysqli_stmt_get_result($prepdeletequote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
