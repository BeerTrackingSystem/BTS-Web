<?php
        include 'db.inc.php';
?>

<?php
	$subject = "A visit was canceled";
        $headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Content-type: text/plain; charset=utf-8' . "\r\n" .
		  'X-Mailer: PHP/' . phpversion();

	$queryrecipients = "SELECT email FROM user;";
        $recipients = mysqli_query($db, $queryrecipients);

	$cookie = $_COOKIE['veteran'];
        $username = substr($cookie, 4);

	$visitid =  $_POST['id'];
	
	$queryvisitveteran = "SELECT name FROM veterans INNER JOIN visits ON veterans.id = visits.veteranid WHERE visits.id = $visitid;";
        $resultvisitveteran = mysqli_query($db, $queryvisitveteran);
	while($row = mysqli_fetch_array($resultvisitveteran))
	{
		$veteranname = $row['name'];
	}

	if ($username == $veteranname)
	{
		$querydelvisit = "DELETE FROM visits WHERE id = $visitid;";
        	$resultdelvisit = mysqli_query($db, $querydelvisit);


		while($row = mysqli_fetch_array($recipients))
        	{
                	$to =  $row['email'];
                	$message = "Aufgepasst!\n\n$username hat seinen Besuch abgesagt!";
                	mail($to, $subject, $message, $headers);
        	}

		echo "<script>
                location.replace('http://$_SERVER[HTTP_HOST]') </script>;
                </script>";
	}
	else
	{
		echo "<script>
		alert('Wrong User/Password');
		location.replace('http://$_SERVER[HTTP_HOST]') </script>;
		</script>";

	}
?>
