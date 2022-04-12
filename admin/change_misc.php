<?php
if ((empty($_POST['newvalue']) && $_POST['newvalue'] != 0) || $_POST['miscobject'] == 'blank' || $_POST['miscattribute'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
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

        $querychangevalue = "UPDATE misc SET value = '$newvalue' WHERE object = '$object' AND attribute = '$attribute';";
        $resultchangevalue = mysqli_query($db, $querychangevalue);

        header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
