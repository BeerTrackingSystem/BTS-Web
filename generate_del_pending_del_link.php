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

	$psdid =  $_POST['id'];
        $queryusername = "SELECT name FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid WHERE pending_strikes_del.id LIKE '$psdid';";
        $resultusername = mysqli_query($db, $queryusername);
	while($row = mysqli_fetch_array($resultusername))
	{
	$username = $row['name'];
	}

        $queryrecipients = "SELECT email FROM user WHERE NOT name LIKE '$username' AND veteran = 0;";
        $recipients = mysqli_query($db, $queryrecipients);
	$recipients_count = mysqli_num_rows($recipients);

        $querydelpendingstrike = "INSERT INTO pending_del_strikes_del (psdid, validations_needed) VALUE ('$psdid', $recipients_count) ;";
        $resultdelpendingstrike =  mysqli_query($db, $querydelpendingstrike);

        $querydelpendingstrikeid = "SELECT id FROM pending_del_strikes_del ORDER BY pending_del_strikes_del.id DESC LIMIT 1;";
        $resultdelpendingstrikeid =  mysqli_query($db, $querydelpendingstrikeid);
        while ($row = $resultdelpendingstrikeid->fetch_assoc()) {
                $delpendingstrikeid = $row['id'];
                }

        while($row = mysqli_fetch_array($recipients))
        {
                $code =  generateRandomString();
                $to =  $row['email'];
                #A few words to say why die pending strike should be removed
                $message = "Die Strike-Löschung von $username soll zurückgenommen werden:\n\nhttp://$_SERVER[HTTP_HOST]/valdeldel.php?valcode=$code";
                mail($to, $subject, $message, $headers);
                $querydelvalidatecode = "INSERT INTO validate_del_strikes_del (pdsdid, code) VALUES ('$delpendingstrikeid', '$code');";
                $resultdelvalidatecode =  mysqli_query($db, $querydelvalidatecode);
        }
?>
