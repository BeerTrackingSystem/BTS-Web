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
	$headers = 'From: postmaster@' . $_SERVER[HTTP_HOST] . "\r\n" .
        	   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
          	   'Content-type: text/plain; charset=utf-8' . "\r\n" .
          	   'X-Mailer: PHP/' . phpversion();

	$username = $_POST['user'];
	$queryrecipients = "SELECT email FROM user WHERE NOT name LIKE '$username';";
	$recipients = mysqli_query($db, $queryrecipients);

	$queryaddpendingstrike = "INSERT INTO pending_strikes_add (userid, date) SELECT user.id, curdate() FROM user WHERE user.name LIKE '$username';";
	$resultaddpendingstrike =  mysqli_query($db, $queryaddpendingstrike);

	$queryaddpendingstrikeid = "SELECT id FROM pending_strikes_add ORDER BY pending_strikes_add.id DESC LIMIT 1;";
	$resultaddpendingstrikeid =  mysqli_query($db, $queryaddpendingstrikeid);
	while ($row = $resultaddpendingstrikeid->fetch_assoc()) {
		$addpendingstrikeid = $row['id'];
		}

	while($row = mysqli_fetch_array($recipients))
	{
		$code =  generateRandomString();
		$to =  $row['email'];
		#A few nice words to say when a new strike needs to be validated - don't change the link at the end!
		$message = "Ein kleiner Klick für dich, aber ein großer Schritt Richtung neuen Kasten!\n\n$username hat nämlich Scheiße gebaut... \n\nhttp://$_SERVER[HTTP_HOST]/valadd.php?valcode=$code";
		mail($to, $subject, $message, $headers);
		$queryaddvalidatecode = "INSERT INTO validate_strikes_add (psaid, code) VALUES ('$addpendingstrikeid', '$code');";
		$resultaddvalidatecode =  mysqli_query($db, $queryaddvalidatecode);
	}
?>
