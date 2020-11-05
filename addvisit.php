<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>

<?php
	$subject = "A visit was added";
        $headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Content-type: text/plain; charset=utf-8' . "\r\n" .
                  'X-Mailer: PHP/' . phpversion();

        $notice = $_POST['visitnotice'];
	$date = $_POST['visitdate'];
	
        $queryrecipients = "SELECT email FROM user;";
        $recipients = mysqli_query($db, $queryrecipients);

        $queryaddvisit = "INSERT INTO visits (veteranid, date, notice) SELECT  veterans.id, '$date', '$notice' FROM veterans INNER JOIN user ON veterans.userid = user.id WHERE user.id LIKE '$userid';";
        $resultaddvisit =  mysqli_query($db, $queryaddvisit);


	while($row = mysqli_fetch_array($recipients))
        {
                $to =  $row['email'];
                $message = "Aufgepasst!\n\n$username ist demnächst ($date) in der Nähe mit folgendem Hinweiß: $notice";
                mail($to, $subject, $message, $headers);
        }
?>
