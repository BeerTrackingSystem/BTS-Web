<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
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
	$subject = "Strike Del Validation needed";
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

	$querydelpendingstrike = "INSERT INTO pending_strikes_del (userid, date, validations_needed, event, reason) SELECT user.id, curdate(), ?, ?, ? FROM user WHERE user.name = ?;";
	$prepdelpendingstrike = mysqli_prepare($db, $querydelpendingstrike);
	mysqli_stmt_bind_param ($prepdelpendingstrike, 'iiss', $recipients_count, $event, $reason, $username);
	mysqli_stmt_execute($prepdelpendingstrike);
	$resultdelpendingstrike = mysqli_stmt_get_result($prepdelpendingstrike);

	$querydelpendingstrikeid = "SELECT id FROM pending_strikes_del ORDER BY pending_strikes_del.id DESC LIMIT 1;";
	$resultdelpendingstrikeid =  mysqli_query($db, $querydelpendingstrikeid);
	while ($row = $resultdelpendingstrikeid->fetch_assoc()) {
    		$delpendingstrikeid = $row['id'];
	}

	while($row = mysqli_fetch_array($recipients))
	{
		$code =  generateRandomString();
		$to =  $row['email'];
		$userid = $row['id'];
		#A few nice words to say when a strike deletion must be validated - don't change the link at the end!
		$message = "Es wurde eine Buße vollbracht!\n\n$username hat für seine Gräueltaten bezahlt: $reason \n\nMöge ihm vergeben werden: https://$_SERVER[HTTP_HOST]/valdel.php?valcode=$code";
		mail($to, $subject, $message, $headers);

		$querydelvalidatecode = "INSERT INTO validate_strikes_del (psdid, code, userid) VALUES (?, ?, ?);";
		$prepdelvalidatecode = mysqli_prepare($db, $querydelvalidatecode);
		mysqli_stmt_bind_param ($prepdelvalidatecode, 'isi', $delpendingstrikeid, $code, $userid);
		mysqli_stmt_execute($prepdelvalidatecode);
		$resultdelvalidatecode = mysqli_stmt_get_result($prepdelvalidatecode);
	}
?>
