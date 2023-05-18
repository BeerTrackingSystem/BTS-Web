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
	$subject = "Strike Add Validation needed";
	$headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
        	   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
          	   'Content-type: text/plain; charset=utf-8' . "\r\n" .
          	   'X-Mailer: PHP/' . phpversion();

	$username = $_POST['user'];
	$reason = $_POST['reason'];
	if (isset($_POST['event']))
	{
		$event = $_POST['event'];
	}
	else
	{
		$event = 0;
	}

	$queryrecipients = "SELECT id, email FROM user WHERE NOT name = ? AND veteran = 0;";
	$preprecipients = mysqli_prepare($db, $queryrecipients);
	mysqli_stmt_bind_param ($preprecipients, 's', $username);
	mysqli_stmt_execute($preprecipients);
	$recipients = mysqli_stmt_get_result($preprecipients);
	$recipients_count = mysqli_num_rows($recipients);

	$queryaddpendingstrike = "INSERT INTO pending_strikes_add (userid, date, validations_needed, event, reason) SELECT user.id, curdate(), ?, ?, ? FROM user WHERE user.name = ?;";
	$prepaddpendingstrike = mysqli_prepare($db, $queryaddpendingstrike);
	mysqli_stmt_bind_param ($prepaddpendingstrike, 'iiss', $recipients_count, $event, $reason, $username);
	mysqli_stmt_execute($prepaddpendingstrike);
	$resultaddpendingstrike = mysqli_stmt_get_result($prepaddpendingstrike);

	$queryaddpendingstrikeid = "SELECT id FROM pending_strikes_add ORDER BY pending_strikes_add.id DESC LIMIT 1;";
	$resultaddpendingstrikeid =  mysqli_query($db, $queryaddpendingstrikeid);
	while ($row = $resultaddpendingstrikeid->fetch_assoc()) {
		$addpendingstrikeid = $row['id'];
		}

	while($row = mysqli_fetch_array($recipients))
	{
		$code =  generateRandomString();
		$to =  $row['email'];
		$userid = $row['id'];
		#A few nice words to say when a new strike needs to be validated - don't change the link at the end!
		$message = "Ein kleiner Klick für dich, aber ein großer Schritt Richtung neuen Kasten!\n\n$username hat nämlich Scheiße gebaut: $reason \n\nhttps://$_SERVER[HTTP_HOST]/valadd.php?valcode=$code";
		mail($to, $subject, $message, $headers);

		$queryaddvalidatecode = "INSERT INTO validate_strikes_add (psaid, code, userid) VALUES (?, ?, ?);";
		$prepaddvalidatecode = mysqli_prepare($db, $queryaddvalidatecode);
		mysqli_stmt_bind_param ($prepaddvalidatecode, 'isi', $addpendingstrikeid, $code, $userid);
		mysqli_stmt_execute($prepaddvalidatecode);
		$resultaddvalidatecode = mysqli_stmt_get_result($prepaddvalidatecode);
	}
?>
