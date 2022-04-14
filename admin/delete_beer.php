<?php
if ($_POST['beerid'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$beerid = $_POST['beerid'];

	$querydelbeer = "DELETE FROM beers WHERE id = ?;";
	$prepdelbeer = mysqli_prepare($db, $querydelbeer);
	mysqli_stmt_bind_param ($prepdelbeer, 'i', $beerid);
	mysqli_stmt_execute($prepdelbeer);
	$resultdelbeer = mysqli_stmt_get_result($prepdelbeer);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
