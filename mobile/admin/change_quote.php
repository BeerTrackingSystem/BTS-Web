<?php
        include '../db.inc.php';
?>

<?php
	$quoteid = $_POST['quoteid'];
	$currentdate = date('Y-m-d');

	$querychangequote = "UPDATE motd SET quoteid = '$quoteid' WHERE `change` LIKE '$currentdate';";
        $changequote = mysqli_query($db, $querychangequote);

	$queryupdatequote = "UPDATE quotes SET lastused = curdate() WHERE id LIKE '$quoteid';";
        $resultupdatequote = mysqli_query($db, $queryupdatequote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
