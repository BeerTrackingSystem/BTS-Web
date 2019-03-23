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
	$headers = 'From: postmaster@' . $_SERVER[HTTP_HOST] . "\r\n" .
        	   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
          	   'Content-type: text/plain; charset=utf-8' . "\r\n" .
          	   'X-Mailer: PHP/' . phpversion();

	$username = $_POST['user'];
	$queryrecipients = "SELECT email FROM user WHERE NOT name LIKE '$username';";
	$recipients = mysqli_query($db, $queryrecipients);

	$querydelpendingstrike = "INSERT INTO pending_strikes_del (userid, date) SELECT user.id, curdate() FROM user WHERE user.name LIKE '$username';";
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
		$message = "Es wurde eine Buße vollbracht!\n\n$username hat für seine Gräueltaten bezahlt. Möge ihm vergeben werden:\n\nhttp://$_SERVER[HTTP_HOST]/validatedel.php?valcode=$code";
		mail($to, $subject, $message, $headers);
		$querydelvalidatecode = "INSERT INTO validate_strikes_del (psdid, code) VALUES ('$delpendingstrikeid', '$code');";
		$resultdelvalidatecode =  mysqli_query($db, $querydelvalidatecode);
	}
?>
