<?php
        include 'db.inc.php';
?>
<?php
if(!empty($_POST["name"]) && !empty($_POST["password"]))
    {
        $username = $_POST['name'];
        $password = $_POST['password'];

        $queryhash = "SELECT password FROM veterans WHERE name LIKE '$username';";
        $resulthash = mysqli_query($db, $queryhash);

        while ($row = $resulthash->fetch_assoc()) {
                $hash = $row['password'];
        }

        if (password_verify($password,"$hash")) {
		define('SECURE_PAGE', true);
                include 'login_veteran_verified.php';
        }
        else
	{
                include 'login_denied.php';
        }
    }
?>
