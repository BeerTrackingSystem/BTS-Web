<?php
	$querylastchange = "SELECT quoteid,`change` FROM motd ORDER BY id DESC LIMIT 1;";
	$resultlastchange = mysqli_query($db, $querylastchange);
	$lastchangerow = mysqli_fetch_array($resultlastchange);

	$lastchange =  $lastchangerow['change'];
	$lastquoteid = $lastchangerow['quoteid'];
	$currentdate = date('Y-m-d');

	if ($lastchange == $currentdate) {
		$querymotd = "SELECT quote FROM quotes INNER JOIN motd ON quotes.id = motd.quoteid WHERE motd.quoteid LIKE '$lastquoteid';";
		$resultmotd = mysqli_query($db, $querymotd);
		$motdrow = mysqli_fetch_array($resultmotd);

		$motd = $motdrow['quote'];
		echo $motd;
	}
	else {
		$querysetmotd = "INSERT INTO motd (`change`, quoteid) SELECT curdate(), quotes.id FROM quotes ORDER BY quotes.lastused LIMIT 1;";
		$resultsetmotd = mysqli_query($db, $querysetmotd);
	
		$querynewmotd = "SELECT quoteid FROM motd ORDER BY id DESC LIMIT 1;";
		$resultnewmotd = mysqli_query($db, $querynewmotd);
		$newmotdrow = mysqli_fetch_array($resultnewmotd);

		$newmotdid = $newmotdrow['quoteid'];	
	
		$queryupdatequote = "UPDATE quotes SET lastused = curdate() WHERE id LIKE '$newmotdid';";
		$resultupdatequote = mysqli_query($db, $queryupdatequote);

		header("Refresh:0");
	}
?>
