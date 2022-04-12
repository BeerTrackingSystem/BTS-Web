<?php
define('index_origin', true);
include '../db.inc.php';
$querygetvalue = "SELECT value FROM misc WHERE object ='" . $_POST['miscobject'] . "' AND attribute = '" . $_POST['miscattribute'] . "' ORDER BY attribute ASC";
$resultgetvalue = mysqli_query($db, $querygetvalue);
$currentvalue = mysqli_fetch_array($resultgetvalue);
echo $currentvalue['value'];
?>
