<?php
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];
	$querycodeexisting = "SELECT id FROM validate_strikes_del WHERE code LIKE '$valcode';";
        $resultcodeexisting = mysqli_query($db, $querycodeexisting);
	

	if(mysqli_num_rows($resultcodeexisting) == "0") {
		#Message when someone already used his validation link
		echo "Obacht... Du hast schon auf den Link geklickt...";
	}
	if(mysqli_num_rows($resultcodeexisting) !== "0") {

	$queryuservalidate1 = "SELECT uservalidate1 FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
	$resultuservalidate1 = mysqli_query($db, $queryuservalidate1);
	while ($row = $resultuservalidate1->fetch_assoc()) {
    		$uservalidate1 = $row['uservalidate1'];
	}

	$queryuservalidate2 = "SELECT uservalidate2 FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
	$resultuservalidate2 = mysqli_query($db, $queryuservalidate2);
	while ($row = $resultuservalidate2->fetch_assoc()) {
    		$uservalidate2 = $row['uservalidate2'];
	}

	$queryuservalidate3 = "SELECT uservalidate3 FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
	$resultuservalidate3 = mysqli_query($db, $queryuservalidate3);
	while ($row = $resultuservalidate3->fetch_assoc()) {
    		$uservalidate3 = $row['uservalidate3'];
	}

	$queryvalidated = "SELECT validated FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
        $resultvalidated = mysqli_query($db, $queryvalidated);
        while ($row = $resultvalidated->fetch_assoc()) {
                $validated = $row['validated'];
        }

	if ($uservalidate1 == "0") {
		$querysetvalidate1 = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET uservalidate1 = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
		$resultsetvalidate1 = mysqli_query($db, $querysetvalidate1);
		#Message when first validation of the pending strike is done
		echo "Validation 1 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch zwei Validierungen!";

	} elseif ($uservalidate2 == "0") {
		$querysetvalidate2 = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET uservalidate2 = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
                $resultsetvalidate2 = mysqli_query($db, $querysetvalidate2);
		#Message when second/final validation of the pending strike is done	
		echo "Validation 2 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlt noch eine Validierung!";

	} elseif ($uservalidate3 == "0") {
		$querysetvalidate3 = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET uservalidate3 = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
                $resultsetvalidate3 = mysqli_query($db, $querysetvalidate3);

		$querycurrentstrikes = "Select currentstrikes FROM current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
		$resultcurrentstrikes = mysqli_query($db, $querycurrentstrikes);
		while ($row = $resultcurrentstrikes->fetch_assoc()) {
                	$currentstrikes = $row['currentstrikes'];
        	}

		if ($currentstrikes >= "5"){
			$querydelstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid SET currentstrikes = currentstrikes-5 WHERE validate_strikes_del.code LIKE '$valcode';";
     			$resultdelstrike = mysqli_query($db, $querydelstrike);
		}
		else {
			$querydelremainingstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid SET currentstrikes = '0' WHERE validate_strikes_del.code LIKE '$valcode';";
		$resultdelremainingstrike = mysqli_query($db, $querydelremainingstrike);
		}

		$queryvalidatepsd ="UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validated = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
     		$resultvalidatepsd = mysqli_query($db, $queryvalidatepsd);
		#Message when third/final validation of the pending strike is done	
		echo "Validation 3 wurde mit dem Code $valcode erfolgreich durchgeführt! Der Strike wurde erfolgreich validiert!";
	} else {
		if ($validated) {
		#Message when pending strike is already validated
		echo "Zu langsam... Strike wurde bereits validiert!";
		}
	}

	$querydelcode = "DELETE FROM validate_strikes_del WHERE code LIKE '$valcode';";
        $resultdelcode = mysqli_query($db, $querydelcode);

	}
?>
