<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
        include 'db.inc.php';
?>

<?php
	$newstock = $_POST['newstock'];

	$querydelcode = "UPDATE current_stock SET amount = '$newstock' WHERE id LIKE '1';";
        $resultdelcode = mysqli_query($db, $querydelcode);
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
