<?php
if (!isset($_POST['veterans-login']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>
<?php
if(!empty($_POST["name"]) && !empty($_POST["password"]))
    {
        $username = $_POST['name'];
        $password = $_POST['password'];

        $queryhash = "SELECT password FROM veterans WHERE name = ?;";
	$prephash = mysqli_prepare($db, $queryhash);
	mysqli_stmt_bind_param ($prephash, 's', $username);
	mysqli_stmt_execute($prephash);
	$resulthash = mysqli_stmt_get_result($prephash);

        while ($row = $resulthash->fetch_assoc()) {
                $hash = $row['password'];
        }

        if (password_verify($password,"$hash")) {
                include 'login_verified.php';
        }
        else
	{
                include 'login_denied.php';
        }
    }
?>
