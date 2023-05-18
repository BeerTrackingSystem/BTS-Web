<?php
if (empty($_POST['keyid']))
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
	$keyid = $_POST['keyid'];

	$querydeletekey = "DELETE FROM api_keys WHERE id = ?;";
	$prepdeletekey = mysqli_prepare($db, $querydeletekey);
	mysqli_stmt_bind_param ($prepdeletekey, 'i', $keyid);
	mysqli_stmt_execute($prepdeletekey);
	$resultdeletekey = mysqli_stmt_get_result($prepdeletekey);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
