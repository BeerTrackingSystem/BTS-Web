<?php
if (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['sms']) && empty($_POST['password']) && empty($_POST['lastpay']))
{
	http_response_code(404);
	die();
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
	$newlastpay = $_POST['lastpay'];
	$newpassword = password_hash($_POST['password'],PASSWORD_DEFAULT);
	$group = substr($_POST['id'],0,1);
	$id = substr($_POST['id'],2);
	#0=user
	#1=veteran

	if ($group == '0')
	{
		if (!empty($_POST['name']))
		{
			$queryupdateuser = "UPDATE user SET name = ? WHERE id = ?;";
			$prepupdateuser = mysqli_prepare($db, $queryupdateuser);
			mysqli_stmt_bind_param ($prepupdateuser, 'si', $newname, $id);
			mysqli_stmt_execute($prepupdateuser);
			$resultupdateuser = mysqli_stmt_get_result($prepupdateuser);
		}

		if (!empty($_POST['email']))
		{
			$queryupdateuser = "UPDATE user SET email = ? WHERE id = ?;";
			$prepupdateuser = mysqli_prepare($db, $queryupdateuser);
                        mysqli_stmt_bind_param ($prepupdateuser, 'si', $newemail, $id);
                        mysqli_stmt_execute($prepupdateuser);
                        $resultupdateuser = mysqli_stmt_get_result($prepupdateuser);
		}

		if (!empty($_POST['sms']))
	        {
			$queryupdateuser = "UPDATE user SET sms = ? WHERE id = ?;";
			$prepupdateuser = mysqli_prepare($db, $queryupdateuser);
                        mysqli_stmt_bind_param ($prepupdateuser, 'ii', $newsms, $id);
                        mysqli_stmt_execute($prepupdateuser);
                        $resultupdateuser = mysqli_stmt_get_result($prepupdateuser);
		}

		if (!empty($_POST['password']))
	        {
			$queryupdateuser = "UPDATE user SET password = ? WHERE id = ?;";
			$prepupdateuser = mysqli_prepare($db, $queryupdateuser);
                        mysqli_stmt_bind_param ($prepupdateuser, 'si', $newpassword, $id);
                        mysqli_stmt_execute($prepupdateuser);
                        $resultupdateuser = mysqli_stmt_get_result($prepupdateuser);
		}

		if (!empty($_POST['lastpay']))
	        {
			$queryupdateuser = "UPDATE user SET last_pay = ? WHERE id = ?;";
			$prepupdateuser = mysqli_prepare($db, $queryupdateuser);
                        mysqli_stmt_bind_param ($prepupdateuser, 'si', $newlastpay, $id);
                        mysqli_stmt_execute($prepupdateuser);
                        $resultupdateuser = mysqli_stmt_get_result($prepupdateuser);
		}
	}

	if ($group == '1')
        {
                if (!empty($_POST['name']))
                {
                        $queryupdateveteran = "UPDATE veterans SET name = ? WHERE id = ?;";
			$prepupdateveteran = mysqli_prepare($db, $queryupdateveteran);
                        mysqli_stmt_bind_param ($prepupdateveteran, 'si', $newname, $id);
                        mysqli_stmt_execute($prepupdateveteran);
                        $resultupdateveteran = mysqli_stmt_get_result($prepupdateveteran);
                }

                if (!empty($_POST['email']))
                {
                        $queryupdateveteran = "UPDATE veterans SET email = ? WHERE id = ?;";
			$prepupdateveteran = mysqli_prepare($db, $queryupdateveteran);
                        mysqli_stmt_bind_param ($prepupdateveteran, 'si', $newemail, $id);
                        mysqli_stmt_execute($prepupdateveteran);
                        $resultupdateveteran = mysqli_stmt_get_result($prepupdateveteran);
                }

                if (!empty($_POST['sms']))
                {
                        $queryupdateveteran = "UPDATE veterans SET sms = ? WHERE id = ?;";
			$prepupdateveteran = mysqli_prepare($db, $queryupdateveteran);
                        mysqli_stmt_bind_param ($prepupdateveteran, 'ii', $newsms, $id);
                        mysqli_stmt_execute($prepupdateveteran);
                        $resultupdateveteran = mysqli_stmt_get_result($prepupdateveteran);
                }

                if (!empty($_POST['password']))
                {
                        $queryupdateveteran = "UPDATE veterans SET password = ? WHERE id = ?;";
			$prepupdateveteran = mysqli_prepare($db, $queryupdateveteran);
                        mysqli_stmt_bind_param ($prepupdateveteran, 'si', $newpassword, $id);
                        mysqli_stmt_execute($prepupdateveteran);
                        $resultupdateveteran = mysqli_stmt_get_result($prepupdateveteran);
                }
        }
	
	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
