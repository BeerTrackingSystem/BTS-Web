<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	function check_login($sid) {
	include 'db.inc.php';
        	$querysession = "SELECT auth_sessions.id, user.id AS userid, user.veteran from auth_sessions INNER JOIN user ON auth_sessions.userid = user.id WHERE auth_sessions.sessionid = '" . $sid . "';";
                $resultsession = mysqli_query($db, $querysession);
                if (mysqli_num_rows($resultsession)==0)
                {
                        return false;
                }
                else
                {
			while ($row = $resultsession->fetch_assoc()) {
                	$isveteran = $row['veteran'];
			$userid = $row['userid'];
        		}

			return array(true, $isveteran, $userid);
                }
        }
?>
