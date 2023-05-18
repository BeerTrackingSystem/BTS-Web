<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
	function check_login($sid) {
	include 'db.inc.php';
        	$querysession = "SELECT auth_sessions.id, user.id AS userid, user.veteran from auth_sessions INNER JOIN user ON auth_sessions.userid = user.id WHERE auth_sessions.sessionid = ?;";
		$prepsession = mysqli_prepare($db, $querysession);
		mysqli_stmt_bind_param ($prepsession, 's', $sid);
		mysqli_stmt_execute($prepsession);
		$resultsession = mysqli_stmt_get_result($prepsession);

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
