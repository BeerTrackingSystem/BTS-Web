<?php
if (empty($_POST['newbeer']) || $_POST['breweryid'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$newbeer = $_POST['newbeer'];
	$breweryid = $_POST['breweryid'];
	$style = $_POST['style'];

	$queryaddbeer = "INSERT INTO beers (name, breweryid, style) VALUES ('$newbeer', '$breweryid', '$style');";
	$resultaddbeer = mysqli_query($db, $queryaddbeer);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
