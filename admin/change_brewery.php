<?php
if (empty($_POST['newbreweryname']) || $_POST['breweryid'] == 'blank')
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
	$newbreweryname = $_POST['newbreweryname'];
	$breweryid = $_POST['breweryid'];

	$querychangebrewery = "UPDATE breweries SET name = ? WHERE id = ?;";
	$prepchangebrewery = mysqli_prepare($db, $querychangebrewery);
	mysqli_stmt_bind_param ($prepchangebrewery, 'si', $newbreweryname, $breweryid);
	mysqli_stmt_execute($prepchangebrewery);
	$resultchangebrewery = mysqli_stmt_get_result($prepchangebrewery);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
