<?php
if (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['password']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$username = $_POST['name'];
	$email = $_POST['email'];

	$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

	$queryaddveteran = "INSERT INTO veterans (userid, name, email, password) SELECT user.id, ?, ?, ? FROM user WHERE user.name = ?;";
	$prepaddveteran  = mysqli_prepare($db, $queryaddveteran);
	mysqli_stmt_bind_param ($prepaddveteran, 'ssss', $username, $email, $password, $username);
	mysqli_stmt_execute($prepaddveteran);
	$resultaddveteran = mysqli_stmt_get_result($prepaddveteran);

	$queryupdateuser = "UPDATE user SET veteran = '1' WHERE name = ?;";
	$prepupdateuser = mysqli_prepare($db, $queryupdateuser);
	mysqli_stmt_bind_param ($prepupdateuser, 's', $username);
	mysqli_stmt_execute($prepupdateuser);
	$resultupdateuser = mysqli_stmt_get_result($prepupdateuser);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
