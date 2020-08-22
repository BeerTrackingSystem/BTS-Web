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
	$subject = "Strike Del Validation needed";
	$headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
        	   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
          	   'Content-type: text/plain; charset=utf-8' . "\r\n" .
          	   'X-Mailer: PHP/' . phpversion();

	$username = $_POST['user'];
	$reason = $_POST['reason'];

	$queryrecipients = "SELECT email FROM user WHERE NOT name LIKE '$username' AND veteran = 0;";
	$recipients = mysqli_query($db, $queryrecipients);
	$recipients_count = mysqli_num_rows($recipients);

	$querydelpendingstrike = "INSERT INTO pending_strikes_del (userid, date, validations_needed, reason) SELECT user.id, curdate(), $recipients_count, '$reason' FROM user WHERE user.name LIKE '$username';";
	$resultdelpendingstrike =  mysqli_query($db, $querydelpendingstrike);

	$querydelpendingstrikeid = "SELECT id FROM pending_strikes_del ORDER BY pending_strikes_del.id DESC LIMIT 1;";
	$resultdelpendingstrikeid =  mysqli_query($db, $querydelpendingstrikeid);
	while ($row = $resultdelpendingstrikeid->fetch_assoc()) {
    		$delpendingstrikeid = $row['id'];
	}

	while($row = mysqli_fetch_array($recipients))
	{
		$code =  generateRandomString();
		$to =  $row['email'];
		#A few nice words to say when a strike deletion must be validated - don't change the link at the end!
		$message = "Es wurde eine Buße vollbracht!\n\n$username hat für seine Gräueltaten bezahlt: $reason \n\nMöge ihm vergeben werden: http://$_SERVER[HTTP_HOST]/valdel.php?valcode=$code";
		mail($to, $subject, $message, $headers);
		$querydelvalidatecode = "INSERT INTO validate_strikes_del (psdid, code) VALUES ('$delpendingstrikeid', '$code');";
		$resultdelvalidatecode =  mysqli_query($db, $querydelvalidatecode);
	}
?>
