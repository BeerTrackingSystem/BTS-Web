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

	$queryadduser = "INSERT INTO user (name, email, password) VALUES (?, ?, ?);";
	$prepadduser = mysqli_prepare($db, $queryadduser);
	mysqli_stmt_bind_param ($prepadduser, 'sss', $username, $email, $password);
	mysqli_stmt_execute($prepadduser);
	$resultadduser = mysqli_stmt_get_result($prepadduser);

	$queryadduserstrikes = "INSERT INTO current_strikes (userid) SELECT id FROM user WHERE user.name = ?;";
	$prepadduserstrikes = mysqli_prepare($db, $queryadduserstrikes);
	mysqli_stmt_bind_param ($prepadduserstrikes, 's', $username);
	mysqli_stmt_execute($prepadduserstrikes);
	$resultadduserstrikes = mysqli_stmt_get_result($prepadduserstrikes);
	
	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
