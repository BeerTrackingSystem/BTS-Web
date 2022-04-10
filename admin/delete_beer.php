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

	$querydelbeer = "DELETE FROM beers WHERE id = '$beerid';";
	$resultdelbeer = mysqli_query($db, $querydelbeer);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
