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

	$queryaddveteran = "INSERT INTO veterans (userid, name, email, password) SELECT user.id, '$username', '$email','$password' FROM user WHERE user.name = '$username';";
        $addveteran = mysqli_query($db, $queryaddveteran);

	$queryupdateuser = "UPDATE user SET veteran = '1' WHERE name LIKE '$username';";
        $updateuser = mysqli_query($db, $queryupdateuser);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
