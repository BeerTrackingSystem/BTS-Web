<?php
if ((empty($_POST['newbeername']) && empty($_POST['newbeerstyle'])) || $_POST['beerid'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
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
		$querychangebeername = "UPDATE beers SET name = '$newbeername' WHERE id = '$beerid';";
		$resultchangebeername = mysqli_query($db, $querychangebeername);
	}

	if (!empty($_POST['newbeerstyle']))
	{
		$querychangebeerstyle = "UPDATE beers SET style = '$newbeerstyle' WHERE id = '$beerid';";
		$resultchangebeerstyle = mysqli_query($db, $querychangebeerstyle);
	}

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
