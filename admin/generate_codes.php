<?php
if (empty($_POST['submit']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>
<?php
        function generateRandomString($length = 6) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }
                return $randomString;
                }
?>

<?php
session_start();
$headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
	   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
           'Content-type: text/plain; charset=utf-8' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

$workflow = $_POST['submit'];
$usercount = $_SESSION['usercount'];
$newneededvalidations = $_SESSION['newneededvalidations'];

if ( $workflow == 'pastrike')
{
	$pastrikeid = $_SESSION['pastrikeid'];
	$subject = "New Validation Code for Strike Add";
	$i = 1;
	while ($i <= $usercount)
	{
		if (isset($_POST['user' . $i . '']))
		{
			$username = $_POST['user' . $i . ''];
			$queryrecipients = "SELECT id, email FROM user WHERE name = ?;";
			$preprecipients = mysqli_prepare($db, $queryrecipients);
			mysqli_stmt_bind_param ($preprecipients, 's', $username);
			mysqli_stmt_execute($preprecipients);
			$recipients = mysqli_stmt_get_result($preprecipients);

			while($row = mysqli_fetch_array($recipients))
        		{
		                $code =  generateRandomString();
		                $to =  $row['email'];
		                $userid = $row['id'];
                		#A few nice words to say when a new strike needs to be validated - don't change the link at the end!
		                $message = "Ein kleiner Klick für dich, aber ein großer Schritt Richtung neuen Kasten!\n\nEs wurde ein neuer Code generiert: \n\nhttp://$_SERVER[HTTP_HOST]/valadd.php?valcode=$code";
                		mail($to, $subject, $message, $headers);

		                $queryaddvalidatecode = "INSERT INTO validate_strikes_add (psaid, code, userid) VALUES (?, ?, ?);";
				$prepaddvalidatecode = mysqli_prepare($db, $queryaddvalidatecode);
				mysqli_stmt_bind_param ($prepaddvalidatecode, 'isi', $pastrikeid, $code, $userid);
				mysqli_stmt_execute($prepaddvalidatecode);
				$resultaddvalidatecode = mysqli_stmt_get_result($prepaddvalidatecode);
        		}
		}

		$i++;
	}
	$queryupdatevalidations = "UPDATE pending_strikes_add SET validations_needed = ? WHERE id = ?;";
	$prepupdatevalidations = mysqli_prepare($db, $queryupdatevalidations);
	mysqli_stmt_bind_param ($prepupdatevalidations, 'ii', $newneededvalidations, $pastrikeid);
	mysqli_stmt_execute($prepupdatevalidations);
	$resultupdatevalidations = mysqli_stmt_get_result($prepupdatevalidations);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
}
elseif ($workflow == 'pdstrike')
{
	$pdstrikeid = $_SESSION['pdstrikeid'];
	$subject = "New Validation Code for Strike Del";
	$i = 1;
        while ($i <= $usercount)
        {
                if (isset($_POST['user' . $i . '']))
                {
                        $username = $_POST['user' . $i . ''];

                        $queryrecipients = "SELECT id, email FROM user WHERE name = ?;";
			$preprecipients = mysqli_prepare($db, $queryrecipients);
			mysqli_stmt_bind_param ($preprecipients, 's', $username);
			mysqli_stmt_execute($preprecipients);
			$recipients = mysqli_stmt_get_result($preprecipients);

                        while($row = mysqli_fetch_array($recipients))
                        {
                                $code =  generateRandomString();
                                $to =  $row['email'];
                                $userid = $row['id'];
                                #A few nice words to say when a new strike needs to be validated - don't change the link at the end!
				$message = "Es wurde eine Buße vollbracht!\n\nEs wurde ein neuer Code generiert. \n\nMöge ihm vergeben werden: http://$_SERVER[HTTP_HOST]/valdel.php?valcode=$code";
                                mail($to, $subject, $message, $headers);

                                $queryaddvalidatecode = "INSERT INTO validate_strikes_del (psdid, code, userid) VALUES (?, ?, ?);";
				$prepaddvalidatecode = mysqli_prepare($db, $queryaddvalidatecode);
				mysqli_stmt_bind_param ($prepaddvalidatecode, 'isi', $pdstrikeid, $code, $userid);
				mysqli_stmt_execute($prepaddvalidatecode);
				$resultaddvalidatecode = mysqli_stmt_get_result($prepaddvalidatecode);
                        }
                }

                $i++;
        }
        $queryupdatevalidations = "UPDATE pending_strikes_del SET validations_needed = ? WHERE id = ?;";
	$prepupdatevalidations = mysqli_prepare($db, $queryupdatevalidations);
	mysqli_stmt_bind_param ($prepupdatevalidations, 'ii', $newneededvalidations, $pdstrikeid);
	mysqli_stmt_execute($prepupdatevalidations);
	$resultupdatevalidations = mysqli_stmt_get_result($prepupdatevalidations);

        header("Location: https://$_SERVER[HTTP_HOST]/admin");
}
?>
