<?php
if ((empty($_POST['newvalue']) && $_POST['newvalue'] != 0) || $_POST['miscobject'] == 'blank' || $_POST['miscattribute'] == 'blank' ||$_POST['miscattribute'] == 'version')
{
	http_response_code(404);
	die();
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
        $object = $_POST['miscobject'];
        $attribute = $_POST['miscattribute'];
        $newvalue = $_POST['newvalue'];

        $querychangevalue = "UPDATE misc SET value = ? WHERE object = ? AND attribute = ?;";
	$prepchangevalue = mysqli_prepare($db, $querychangevalue);
	mysqli_stmt_bind_param ($prepchangevalue, 'sss', $newvalue, $object, $attribute);
	mysqli_stmt_execute($prepchangevalue);
	$resultchangevalue = mysqli_stmt_get_result($prepchangevalue);

        header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
