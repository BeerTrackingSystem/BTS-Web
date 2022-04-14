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

        $queryaddvisit = "INSERT INTO visits (veteranid, date, notice) SELECT  veterans.id, ?, ? FROM veterans INNER JOIN user ON veterans.userid = user.id WHERE user.id = ?;";
	$prepaddvisit = mysqli_prepare($db, $queryaddvisit);
	mysqli_stmt_bind_param ($prepaddvisit, 'ssi', $date, $notice, $userid);
	mysqli_stmt_execute($prepaddvisit);
	$resultaddvisit = mysqli_stmt_get_result($prepaddvisit);


	while($row = mysqli_fetch_array($recipients))
        {
                $to =  $row['email'];
                $message = "Aufgepasst!\n\n$username ist demnächst ($date) in der Nähe mit folgendem Hinweiß: $notice";
                mail($to, $subject, $message, $headers);
        }
?>
