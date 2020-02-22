<?php
        include '../db.inc.php';
?>

<?php
	$username = $_POST['name'];
	$email = $_POST['email'];

	$queryaddveteran = "INSERT INTO veterans (name, email) VALUES ('$username', '$email');";
        $addveteran = mysqli_query($db, $queryaddveteran);

	$querydeluserstrikes = "DELETE current_strikes FROM current_strikes INNER JOIN user ON current_strikes.userid = user.id WHERE user.name LIKE '$username';";
	$deluserstrikes = mysqli_query($db, $querydeluserstrikes);

	$querydeluser = "DELETE FROM user WHERE name LIKE '$username';";
        $deluser = mysqli_query($db, $querydeluser);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
