<?php
if (empty($_POST['description']))
{
	http_response_code(404);
	die();
}
if (empty($_POST['generatedKey']))
{
	echo '<script>alert("First generate key!");</script>';
	echo '<script>location.replace(\'https://' . $_SERVER[HTTP_HOST] . '/admin\')</script>';
    	die();
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$description = $_POST['description'];
	$key = $_POST['generatedKey'];

	$queryaddkey = "INSERT INTO api_keys (apikey, description) VALUES (?, ?);";
	$prepaddkey = mysqli_prepare($db, $queryaddkey);
	mysqli_stmt_bind_param ($prepaddkey, 'ss', $key, $description);
	mysqli_stmt_execute($prepaddkey);
	$resultaddkey = mysqli_stmt_get_result($prepaddkey);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
