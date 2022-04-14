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
	$currentdate = date('Y-m-d');

	$querychangequote = "UPDATE motd SET quoteid = ? WHERE `change` = ?;";
	$prepchangequote = mysqli_prepare($db, $querychangequote);
	mysqli_stmt_bind_param ($prepchangequote, 'is', $quoteid, $currentdate);
	mysqli_stmt_execute($prepchangequote);
	$resultchangequote = mysqli_stmt_get_result($prepchangequote);

	$queryupdatequote = "UPDATE quotes SET lastused = curdate() WHERE id = ?;";
	$prepupdatequote = mysqli_prepare($db, $queryupdatequote);
	mysqli_stmt_bind_param ($prepupdatequote, 'i', $quoteid);
	mysqli_stmt_execute($prepupdatequote);
	$resultupdatequote = mysqli_stmt_get_result($prepupdatequote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
