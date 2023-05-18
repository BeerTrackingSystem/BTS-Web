<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>

<?php
	$subject = "A visit was canceled";
        $headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
                  'Content-type: text/plain; charset=utf-8' . "\r\n" .
		  'X-Mailer: PHP/' . phpversion();

	$queryrecipients = "SELECT email FROM user;";
        $recipients = mysqli_query($db, $queryrecipients);

	$queryusername = "SELECT name FROM user WHERE id = ?;";
	$prepusername = mysqli_prepare($db, $queryusername);
	mysqli_stmt_bind_param ($prepusername, 'i', $userid);
	mysqli_stmt_execute($prepusername);
	$resultusername = mysqli_stmt_get_result($prepusername);
	while($row = mysqli_fetch_array($resultusername))
	{
		$username = $row['name'];
	}

	$visitid =  $_POST['id'];
		
	$queryvisitveteran = "SELECT name FROM veterans INNER JOIN visits ON veterans.id = visits.veteranid WHERE visits.id = ?;";
	$prepvisitveteran = mysqli_prepare($db, $queryvisitveteran);
	mysqli_stmt_bind_param ($prepvisitveteran, 'i', $visitid);
	mysqli_stmt_execute($prepvisitveteran);
	$resultvisitveteran = mysqli_stmt_get_result($prepvisitveteran);

	while($row = mysqli_fetch_array($resultvisitveteran))
	{
		$veteranname = $row['name'];
	}

	if ($username == $veteranname)
	{
		$querydelvisit = "DELETE FROM visits WHERE id = ?;";
		$prepdelvisit = mysqli_prepare($db, $querydelvisit);
		mysqli_stmt_bind_param ($prepdelvisit, 'i', $visitid);
		mysqli_stmt_execute($prepdelvisit);
		$resultdelvisit = mysqli_stmt_get_result($prepdelvisit);

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
