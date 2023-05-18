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
        $subject = "Delete Pending-Strike-Del - Validation needed";
        $headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                   'Content-type: text/plain; charset=utf-8' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

	$psdid =  $_POST['id'];
        $queryusername = "SELECT name FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid WHERE pending_strikes_del.id = ?;";
	$prepusername = mysqli_prepare($db, $queryusername);
	mysqli_stmt_bind_param ($prepusername, 'i', $psdid);
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

        $querydelpendingstrike = "INSERT INTO pending_del_strikes_del (psdid, validations_needed) VALUE (?, ?);";
	$prepdelpendingstrike = mysqli_prepare($db, $querydelpendingstrike);
	mysqli_stmt_bind_param ($prepdelpendingstrike, 'ii', $psdid, $recipients_count);
	mysqli_stmt_execute($prepdelpendingstrike);
	$resultdelpendingstrike = mysqli_stmt_get_result($prepdelpendingstrike);

        $querydelpendingstrikeid = "SELECT id FROM pending_del_strikes_del ORDER BY pending_del_strikes_del.id DESC LIMIT 1;";
        $resultdelpendingstrikeid =  mysqli_query($db, $querydelpendingstrikeid);
        while ($row = $resultdelpendingstrikeid->fetch_assoc()) {
                $delpendingstrikeid = $row['id'];
                }

        while($row = mysqli_fetch_array($recipients))
        {
                $code =  generateRandomString();
                $to =  $row['email'];
		$userid = $row['id'];
                #A few words to say why die pending strike should be removed
                $message = "Die Strike-Löschung von $username soll zurückgenommen werden:\n\nhttps://$_SERVER[HTTP_HOST]/valdeldel.php?valcode=$code";
                mail($to, $subject, $message, $headers);

                $querydelvalidatecode = "INSERT INTO validate_del_strikes_del (pdsdid, code, userid) VALUES (?, ?, ?);";
		$prepdelvalidatecode = mysqli_prepare($db, $querydelvalidatecode);
		mysqli_stmt_bind_param ($prepdelvalidatecode, 'isi', $delpendingstrikeid, $code, $userid);
		mysqli_stmt_execute($prepdelvalidatecode);
		$resultdelvalidatecode = mysqli_stmt_get_result($prepdelvalidatecode);
        }
?>
