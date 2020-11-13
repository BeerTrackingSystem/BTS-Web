<?php
if (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['sms']) && empty($_POST['password']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
if ($_POST['id'] == "blank")
{
	echo '<script>alert("Please choose a user/veteran!");</script>';
	echo '<script>location.replace(\'http://' . $_SERVER[HTTP_HOST] . '/admin\')</script>';
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$newname = $_POST['name'];
	$newemail = $_POST['email'];
	$newsms = $_POST['sms'];
	$newpassword = password_hash($_POST['password'],PASSWORD_DEFAULT);
	$group = substr($_POST['id'],0,1);
	$id = substr($_POST['id'],2);
	#0=user
	#1=veteran

	if ($group == '0')
	{
		if (!empty($_POST['name']))
		{
			$queryupdateuser = "UPDATE user SET name = '$newname' WHERE id = '$id';";
		        $updateuser = mysqli_query($db, $queryupdateuser);
		}

		if (!empty($_POST['email']))
		{
			$queryupdateuser = "UPDATE user SET email = '$newemail' WHERE id = '$id';";
		        $updateuser = mysqli_query($db, $queryupdateuser);
		}

		if (!empty($_POST['sms']))
	        {
			$queryupdateuser = "UPDATE user SET sms = '$newsms' WHERE id = '$id';";
		        $updateuser = mysqli_query($db, $queryupdateuser);
		}

		if (!empty($_POST['password']))
	        {
			$queryupdateuser = "UPDATE user SET password = '$newpassword' WHERE id = '$id';";
		        $updateuser = mysqli_query($db, $queryupdateuser);
		}
	}

	if ($group == '1')
        {
                if (!empty($_POST['name']))
                {
                        $queryupdateveteran = "UPDATE veterans SET name = '$newname' WHERE id = '$id';";
                        $updateveteran = mysqli_query($db, $queryupdateveteran);
                }

                if (!empty($_POST['email']))
                {
                        $queryupdateveteran = "UPDATE veterans SET email = '$newemail' WHERE id = '$id';";
                        $updateveteran = mysqli_query($db, $queryupdateveteran);
                }

                if (!empty($_POST['sms']))
                {
                        $queryupdateveteran = "UPDATE veterans SET sms = '$newsms' WHERE id = '$id';";
                        $updateveteran = mysqli_query($db, $queryupdateveteran);
                }

                if (!empty($_POST['password']))
                {
                        $queryupdateveteran = "UPDATE veterans SET password = '$newpassword' WHERE id = '$id';";
                        $updateveteran = mysqli_query($db, $queryupdateveteran);
                }
        }
	
	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
