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

	$queryaddbeer = "INSERT INTO beers (name, breweryid, style) VALUES (?, ?, ?);";
	$prepaddbeer = mysqli_prepare($db, $queryaddbeer);
	mysqli_stmt_bind_param ($prepaddbeer, 'sis', $newbeer, $breweryid, $style);
	mysqli_stmt_execute($prepaddbeer);
	$resultaddbeer = mysqli_stmt_get_result($prepaddbeer);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
