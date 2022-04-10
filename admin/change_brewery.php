<?php
if (empty($_POST['newbreweryname']) || $_POST['breweryid'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$newbreweryname = $_POST['newbreweryname'];
	$breweryid = $_POST['breweryid'];

	$querychangebrewery = "UPDATE breweries SET name = '$newbreweryname' WHERE id = '$breweryid';";
	$resultchangebrewery = mysqli_query($db, $querychangebrewery);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
