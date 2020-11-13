<?php
if (!isset($_POST['visitnotice']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
	$sessionid=$_COOKIE['PHPSESSID'];
?>

<?php
	function check_login($sid) {
        include 'db.inc.php';
                $querysession = "SELECT auth_sessions.id, user.id, user.veteran from auth_sessions INNER JOIN user ON auth_sessions.userid = user.id WHERE auth_sessions.sessionid = '$sid';";
                $resultsession = mysqli_query($db, $querysession);
                if (mysqli_num_rows($resultsession)==0)
                {
                        return false;
                }
                else
                {
                        while ($row = $resultsession->fetch_assoc()) {
                        $isveteran = $row['veteran'];
                        $userid = $row['id'];
                        }

                        return array(true, $isveteran, $userid);
                }
        }
?>
<?php
	$userid = check_login($sessionid)[2];

	include 'addvisit.php';
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
