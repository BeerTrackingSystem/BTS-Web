<?php
if (!isset($_POST['delcodes']) && !isset($_POST['addcodes']) && !isset($_POST['deladdcodes']) && !isset($_POST['deldelcodes']))
{
	http_response_code(404);
	die();
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
$headers = 'From: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
	   'Reply-To: noreply@' . $_SERVER[HTTP_HOST] . "\r\n" .
           'Content-type: text/plain; charset=utf-8' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

$addcodeid = $_POST['addcodes'];
$delcodeid = $_POST['delcodes'];
$deladdcodeid = $_POST['deladdcodes'];
$deldelcodeid = $_POST['deldelcodes'];

$subject = "Resended Code";
if ( $addcodeid != 'blank')
{
			$queryinfos = "SELECT email, validate_strikes_add.code, pending_strikes_add.reason FROM user INNER JOIN validate_strikes_add ON user.id = validate_strikes_add.userid INNER JOIN pending_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.id = ?;";
			$prepinfos = mysqli_prepare($db, $queryinfos);
			mysqli_stmt_bind_param ($prepinfos, 'i', $addcodeid);
			mysqli_stmt_execute($prepinfos);
			$infos = mysqli_stmt_get_result($prepinfos);

			while($row = mysqli_fetch_array($infos))
        		{
		                $to =  $row['email'];
		                $code =  $row['code'];
		                $reason =  $row['reason'];
                		#A few nice words to say when a new strike needs to be validated - don't change the link at the end!
		                $message = "Ein kleiner Klick für dich, aber ein großer Schritt Richtung neuen Kasten!\n\nGrund: $reason\n\nhttp://$_SERVER[HTTP_HOST]/valadd.php?valcode=$code";
                		mail($to, $subject, $message, $headers);
        		}
}
if ($delcodeid != 'blank')
{
	$queryinfos = "SELECT email, validate_strikes_del.code, pending_strikes_del.reason FROM user INNER JOIN validate_strikes_del ON user.id = validate_strikes_del.userid INNER JOIN pending_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.id = ?;";
			$prepinfos = mysqli_prepare($db, $queryinfos);
                        mysqli_stmt_bind_param ($prepinfos, 'i', $delcodeid);
                        mysqli_stmt_execute($prepinfos);
                        $infos = mysqli_stmt_get_result($prepinfos);

                        while($row = mysqli_fetch_array($infos))
                        {
                                $to =  $row['email'];
                                $code =  $row['code'];
                                $reason =  $row['reason'];
                                #A few nice words to say when a new strike needs to be validated - don't change the link at the end!
                                $message = "Es wurde eine Buße vollbracht!\n\nGrund: $reason\n\nhttp://$_SERVER[HTTP_HOST]/valdel.php?valcode=$code";
                                mail($to, $subject, $message, $headers);
                        }
}
if ($deladdcodeid != 'blank')
{
        $queryinfos = "SELECT email, validate_del_strikes_add.code, pending_strikes_add.reason FROM user INNER JOIN validate_del_strikes_add ON user.id = validate_del_strikes_add.userid INNER JOIN pending_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid INNER JOIN pending_strikes_add ON pending_strikes_add.id = pending_del_strikes_add.psaid WHERE validate_del_strikes_add.id = ?;";
			$prepinfos = mysqli_prepare($db, $queryinfos);
                        mysqli_stmt_bind_param ($prepinfos, 'i', $deladdcodeid);
                        mysqli_stmt_execute($prepinfos);
                        $infos = mysqli_stmt_get_result($prepinfos);

                        while($row = mysqli_fetch_array($infos))
                        {
                                $to =  $row['email'];
                                $code =  $row['code'];
                                $reason =  $row['reason'];
                                #A few nice words to say when a new strike needs to be validated - don't change the link at the end!
                                $message = "Der Pending-Strike mit dem Grund -$reason- soll gelöscht werden:\n\nhttp://$_SERVER[HTTP_HOST]/valdeladd.php?valcode=$code";
                                mail($to, $subject, $message, $headers);
                        }
}
if ($deldelcodeid != 'blank')
{
        $queryinfos = "SELECT email, validate_del_strikes_del.code, pending_strikes_del.reason FROM user INNER JOIN validate_del_strikes_del ON user.id = validate_del_strikes_del.userid INNER JOIN pending_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid INNER JOIN pending_strikes_del ON pending_strikes_del.id = pending_del_strikes_del.psdid WHERE validate_del_strikes_del.id = ?;";
			$prepinfos = mysqli_prepare($db, $queryinfos);
                        mysqli_stmt_bind_param ($prepinfos, 'i', $deldelcodeid);
                        mysqli_stmt_execute($prepinfos);
                        $infos = mysqli_stmt_get_result($prepinfos);

                        while($row = mysqli_fetch_array($infos))
                        {
                                $to =  $row['email'];
                                $code =  $row['code'];
                                $reason =  $row['reason'];
                                #A few nice words to say when a new strike needs to be validated - don't change the link at the end!
                                $message = "Der Pending-Strike mit dem Grund -$reason- soll gelöscht werden:\n\nhttp://$_SERVER[HTTP_HOST]/valdeldel.php?valcode=$code";
                                mail($to, $subject, $message, $headers);
                        }
}
	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
