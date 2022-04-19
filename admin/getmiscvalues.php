<?php
define('index_origin', true);
include '../db.inc.php';
$querygetvalue = "SELECT value FROM misc WHERE object = ? AND attribute = ? ORDER BY attribute ASC";
$prepgetvalue = mysqli_prepare($db, $querygetvalue);
mysqli_stmt_bind_param ($prepgetvalue, 'ss', $_POST['miscobject'], $_POST['miscattribute']);
mysqli_stmt_execute($prepgetvalue);
$resultgetvalue = mysqli_stmt_get_result($prepgetvalue);
$currentvalue = mysqli_fetch_array($resultgetvalue);
echo htmlspecialchars($currentvalue['value']);
?>
