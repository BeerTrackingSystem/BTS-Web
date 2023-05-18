<?php
if (!isset($_POST['newstock']))
{
	http_response_code(404);
	die();
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>

<?php
	$newstock = $_POST['newstock'];

	$querydelcode = "UPDATE current_stock SET amount = ? WHERE id LIKE '1';";
	$prepdelcode = mysqli_prepare($db, $querydelcode);
	mysqli_stmt_bind_param ($prepdelcode, 'i', $newstock);
	mysqli_stmt_execute($prepdelcode);
	$resultdelcode = mysqli_stmt_get_result($prepdelcode);

	header("Location: http://$_SERVER[HTTP_HOST]");
?>
