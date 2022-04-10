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
	$querydelrating = "DELETE FROM ranking_beers WHERE userid = '" . $userid . "' AND beerid = '" . $beerid . "';";
	$resultdelrating = mysqli_query($db, $querydelrating);
}
else
{
	$querygetrating = "SELECT count(ranking_beers.id) AS currentrating FROM ranking_beers WHERE userid = '" . $userid . "' AND beerid = '" . $beerid . "';";
        $resultgetrating = mysqli_query($db, $querygetrating);
	$rowgetrating = mysqli_fetch_array($resultgetrating);
	
	if ($rowgetrating['currentrating'] == '1')
	{
		$querychangerating = "UPDATE ranking_beers SET ranking_beers.rating = '" . $rating . "' WHERE userid = '" . $userid . "' AND beerid = '" . $beerid . "';";
		$resultchangerating = mysqli_query($db, $querychangerating);
	}
	elseif ($rowgetrating['currentrating'] == '0')
	{
		$queryaddrating = "INSERT INTO ranking_beers (userid, beerid, rating) VALUES ('" . $userid . "','" . $beerid . "','" . $rating . "');";
		$resultaddrating = mysqli_query($db, $queryaddrating);
	}
}

header("Location: https://$_SERVER[HTTP_HOST]/ranking");
?>
