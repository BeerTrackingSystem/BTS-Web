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
        $headers = 'From: postmaster@' . $_SERVER[HTTP_HOST] . "\r\n" .
                   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                   'Content-type: text/plain; charset=utf-8' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

	$psaid =  $_POST['id'];
        $queryusername = "SELECT name FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid WHERE pending_strikes_add.id LIKE '$psaid';";
        $resultusername = mysqli_query($db, $queryusername);
	while($row = mysqli_fetch_array($resultusername))
	{
	$username = $row['name'];
	}

        $queryrecipients = "SELECT email FROM user WHERE NOT name LIKE '$username';";
        $recipients = mysqli_query($db, $queryrecipients);

        $queryaddpendingstrike = "INSERT INTO pending_del_strikes_add (psaid) VALUE ('$psaid') ;";
        $resultaddpendingstrike =  mysqli_query($db, $queryaddpendingstrike);

        $queryaddpendingstrikeid = "SELECT id FROM pending_del_strikes_add ORDER BY pending_del_strikes_add.id DESC LIMIT 1;";
        $resultaddpendingstrikeid =  mysqli_query($db, $queryaddpendingstrikeid);
        while ($row = $resultaddpendingstrikeid->fetch_assoc()) {
                $addpendingstrikeid = $row['id'];
                }

        while($row = mysqli_fetch_array($recipients))
        {
                $code =  generateRandomString();
                $to =  $row['email'];
                #A few words to say why die pending strike should be removed
                $message = "Der Strike von $username soll gelöscht werden:\n\nhttp://$_SERVER[HTTP_HOST]/valdeladd.php?valcode=$code";
                mail($to, $subject, $message, $headers);
                $queryaddvalidatecode = "INSERT INTO validate_del_strikes_add (pdsaid, code) VALUES ('$addpendingstrikeid', '$code');";
                $resultaddvalidatecode =  mysqli_query($db, $queryaddvalidatecode);
        }
?>
