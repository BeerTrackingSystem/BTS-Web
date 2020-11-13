<?php
if (!isset($_POST['newstock']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>

<?php
	$newstock = $_POST['newstock'];

	$querydelcode = "UPDATE current_stock SET amount = '$newstock' WHERE id LIKE '1';";
        $resultdelcode = mysqli_query($db, $querydelcode);
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
