<?php
if (!isset($_POST['beer']) || $_POST['beer'] == 'blank')
{
    die('<h1>Direct File Access Prohibited</h1>');
}
else
{
	define('index_origin', true);
	include '../db.inc.php';
        include '../check_login.php';
        $sessionid=$_COOKIE['PHPSESSID'];
}
?>
<?php
$breweryid = $_POST['brewery'];	
$beerid = $_POST['beer'];	
$rating = $_POST['rating'];
$userid = check_login($sessionid)[2];

if ($rating == '')
{
	$querydelrating = "DELETE FROM ranking_beers WHERE userid = ? AND beerid = ?;";
	$prepdelrating = mysqli_prepare($db, $querydelrating);
	mysqli_stmt_bind_param ($prepdelrating, 'ii', $userid, $beerid);
	mysqli_stmt_execute($prepdelrating);
	$resultdelrating = mysqli_stmt_get_result($prepdelrating);
}
else
{
	$querygetrating = "SELECT count(ranking_beers.id) AS currentrating FROM ranking_beers WHERE userid = ? AND beerid = ?;";
	$prepgetrating = mysqli_prepare($db, $querygetrating);
	mysqli_stmt_bind_param ($prepgetrating, 'ii', $userid, $beerid);
	mysqli_stmt_execute($prepgetrating);
	$resultgetrating = mysqli_stmt_get_result($prepgetrating);
	$rowgetrating = mysqli_fetch_array($resultgetrating);
	
	if ($rowgetrating['currentrating'] == '1')
	{
		$querychangerating = "UPDATE ranking_beers SET ranking_beers.rating = ? WHERE userid = ? AND beerid = ?;";
		$prepchangerating = mysqli_prepare($db, $querychangerating);
		mysqli_stmt_bind_param ($prepchangerating, 'iii', $rating, $userid, $beerid);
		mysqli_stmt_execute($prepchangerating);
		$resultchangerating = mysqli_stmt_get_result($prepchangerating);
	}
	elseif ($rowgetrating['currentrating'] == '0')
	{
		$queryaddrating = "INSERT INTO ranking_beers (userid, beerid, rating) VALUES (?, ?, ?);";
		$prepaddrating = mysqli_prepare($db, $queryaddrating);
		mysqli_stmt_bind_param ($prepaddrating, 'iii', $userid, $beerid, $rating);
		mysqli_stmt_execute($prepaddrating);
		$resultaddrating = mysqli_stmt_get_result($prepaddrating);
	}
}

header("Location: https://$_SERVER[HTTP_HOST]/ranking");
?>
