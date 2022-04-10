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

	$queryaddbrewery = "INSERT INTO breweries (name) VALUES ('$newbrewery');";
        $resultaddbrewery = mysqli_query($db, $queryaddbrewery);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
