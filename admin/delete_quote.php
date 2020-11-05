<?php
if (empty($_POST['quoteid']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$quoteid = $_POST['quoteid'];

	$querychangequote = "DELETE FROM motd WHERE quoteid = '$quoteid';";
        $changequote = mysqli_query($db, $querychangequote);

	$queryupdatequote = "DELETE FROM quotes WHERE id LIKE '$quoteid';";
        $resultupdatequote = mysqli_query($db, $queryupdatequote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
