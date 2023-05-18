<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
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
        $subject = "Delete Pending-Strike-Add - Validation needed";
        $headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                   'Content-type: text/plain; charset=utf-8' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

	$psaid =  $_POST['id'];
        $queryusername = "SELECT name FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid WHERE pending_strikes_add.id = ?;";
	$prepusername = mysqli_prepare($db, $queryusername);
	mysqli_stmt_bind_param ($prepusername, 'i', $psaid);
	mysqli_stmt_execute($prepusername);
	$resultusername = mysqli_stmt_get_result($prepusername);

	while($row = mysqli_fetch_array($resultusername))
	{
	$username = $row['name'];
	}

        $queryrecipients = "SELECT id, email FROM user WHERE NOT name = ? AND veteran = 0;";
	$preprecipients = mysqli_prepare($db, $queryrecipients);
	mysqli_stmt_bind_param ($preprecipients, 's', $username);
	mysqli_stmt_execute($preprecipients);
	$recipients = mysqli_stmt_get_result($preprecipients);

	$recipients_count = mysqli_num_rows($recipients);

        $queryaddpendingstrike = "INSERT INTO pending_del_strikes_add (psaid, validations_needed) VALUE (?, ?);";
	$prepaddpendingstrike = mysqli_prepare($db, $queryaddpendingstrike);
	mysqli_stmt_bind_param ($prepaddpendingstrike, 'ii', $psaid, $recipients_count);
	mysqli_stmt_execute($prepaddpendingstrike);
	$resultaddpendingstrike = mysqli_stmt_get_result($prepaddpendingstrike);

        $queryaddpendingstrikeid = "SELECT id FROM pending_del_strikes_add ORDER BY pending_del_strikes_add.id DESC LIMIT 1;";
        $resultaddpendingstrikeid =  mysqli_query($db, $queryaddpendingstrikeid);
        while ($row = $resultaddpendingstrikeid->fetch_assoc()) {
                $addpendingstrikeid = $row['id'];
                }

        while($row = mysqli_fetch_array($recipients))
        {
                $code =  generateRandomString();
                $to =  $row['email'];
		$userid = $row['id'];
                #A few words to say why die pending strike should be removed
                $message = "Der Pending-Strike von $username soll gelöscht werden:\n\nhttps://$_SERVER[HTTP_HOST]/valdeladd.php?valcode=$code";
                mail($to, $subject, $message, $headers);

                $queryaddvalidatecode = "INSERT INTO validate_del_strikes_add (pdsaid, code, userid) VALUES (?, ?, ?);";
		$prepaddvalidatecode = mysqli_prepare($db, $queryaddvalidatecode);
		mysqli_stmt_bind_param ($prepaddvalidatecode, 'isi', $addpendingstrikeid, $code, $userid);
		mysqli_stmt_execute($prepaddvalidatecode);
		$resultaddvalidatecode = mysqli_stmt_get_result($prepaddvalidatecode);
        }
?>
