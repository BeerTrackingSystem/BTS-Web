<?php
if (empty($_POST['newbrewery']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$newbrewery = $_POST['newbrewery'];

	$queryaddbrewery = "INSERT INTO breweries (name) VALUES (?);";
	$prepaddbrewery = mysqli_prepare($db, $queryaddbrewery);
	mysqli_stmt_bind_param ($prepaddbrewery, 's', $newbrewery);
	mysqli_stmt_execute($prepaddbrewery);
	$resultaddbrewery = mysqli_stmt_get_result($prepaddbrewery);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
