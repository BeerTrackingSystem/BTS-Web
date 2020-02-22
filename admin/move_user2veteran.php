<?php
        include '../db.inc.php';
?>

<?php
	$username = $_POST['name'];
	$email = $_POST['email'];

	$queryaddveteran = "INSERT INTO veterans (name, email) VALUES ('$username', '$email');";
        $addveteran = mysqli_query($db, $queryaddveteran);

	$queryupdateuser = "UPDATE user SET veteran = '1' WHERE name LIKE '$username';";
        $updateuser = mysqli_query($db, $queryupdateuser);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
