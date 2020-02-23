<?php
        include '../db.inc.php';
?>

<?php
	$username = $_POST['name'];
	$email = $_POST['email'];

	$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

	$queryaddveteran = "INSERT INTO veterans (name, email, password) VALUES ('$username', '$email','$password');";
        $addveteran = mysqli_query($db, $queryaddveteran);

	$queryupdateuser = "UPDATE user SET veteran = '1' WHERE name LIKE '$username';";
        $updateuser = mysqli_query($db, $queryupdateuser);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
