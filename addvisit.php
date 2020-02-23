<?php
        include 'db.inc.php';
?>

<?php
	$subject = "A visit was added";
        $headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Content-type: text/plain; charset=utf-8' . "\r\n" .
                  'X-Mailer: PHP/' . phpversion();

	$cookie = $_COOKIE['veteran'];
        $username = substr($cookie, 4);
        $notice = $_POST['visitnotice'];
	$date = $_POST['visitdate'];
	
        $queryrecipients = "SELECT email FROM user;";
        $recipients = mysqli_query($db, $queryrecipients);

        $queryaddvisit = "INSERT INTO visits (veteranid, date, notice) SELECT  veterans.id, '$date', '$notice' FROM veterans WHERE veterans.name LIKE '$username';";
        $resultaddvisit =  mysqli_query($db, $queryaddvisit);


	while($row = mysqli_fetch_array($recipients))
        {
                $to =  $row['email'];
                #A few nice words to say when a new strike needs to be validated - don't change the link at the end!
                $message = "Aufgepasst!\n\n$username ist demnächst ($date) in der Nähe mit folgendem Hinweiß: $notice";
                mail($to, $subject, $message, $headers);
        }
?>
