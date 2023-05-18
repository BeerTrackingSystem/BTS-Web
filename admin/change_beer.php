<?php
if ((empty($_POST['newbeername']) && empty($_POST['newbeerstyle'])) || $_POST['beerid'] == 'blank')
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
	$newbeername = $_POST['newbeername'];
	$newbeerstyle = $_POST['newbeerstyle'];
	$beerid = $_POST['beerid'];

	if (!empty($_POST['newbeername']))
	{
		$querychangebeername = "UPDATE beers SET name = ? WHERE id = ?;";
		$prepchangebeername = mysqli_prepare($db, $querychangebeername);
		mysqli_stmt_bind_param ($prepchangebeername, 'si', $newbeername, $beerid);
		mysqli_stmt_execute($prepchangebeername);
		$resultchangebeername = mysqli_stmt_get_result($prepchangebeername);
	}

	if (!empty($_POST['newbeerstyle']))
	{
		$querychangebeerstyle = "UPDATE beers SET style = ? WHERE id = ?;";
		$prepchangebeerstyle = mysqli_prepare($db, $querychangebeerstyle);
		mysqli_stmt_bind_param ($prepchangebeerstyle, 'si', $newbeerstyle, $beerid);
		mysqli_stmt_execute($prepchangebeerstyle);
		$resultchangebeerstyle = mysqli_stmt_get_result($prepchangebeerstyle);
	}

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
