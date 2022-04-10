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

	$querydelbrewery = "DELETE FROM breweries WHERE id = '$breweryid';";
	$resultdelbrewery = mysqli_query($db, $querydelbrewery);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
