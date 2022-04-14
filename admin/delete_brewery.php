<?php
if ($_POST['breweryid'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$breweryid = $_POST['breweryid'];

	$querydelbrewery = "DELETE FROM breweries WHERE id = ?;";
	$prepdelbrewery = mysqli_prepare($db, $querydelbrewery);
	mysqli_stmt_bind_param ($prepdelbrewery, 'i', $breweryid);
	mysqli_stmt_execute($prepdelbrewery);
	$resultdelbrewery = mysqli_stmt_get_result($prepdelbrewery);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
