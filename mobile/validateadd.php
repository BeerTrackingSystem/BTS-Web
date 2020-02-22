<?php
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];
	$querycodeexisting = "SELECT id FROM validate_strikes_add WHERE code LIKE '$valcode';";
        $resultcodeexisting = mysqli_query($db, $querycodeexisting);
	
	if(mysqli_num_rows($resultcodeexisting) == "0") {
		#Message when someone already used his validation link
		echo "Obacht... Du hast schon auf den Link geklickt...";
	}
	if(mysqli_num_rows($resultcodeexisting) !== "0") {

	$queryuservalidate1 = "SELECT uservalidate1 FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
	$resultuservalidate1 = mysqli_query($db, $queryuservalidate1);
	while ($row = $resultuservalidate1->fetch_assoc()) {
    		$uservalidate1 = $row['uservalidate1'];
	}

	$queryuservalidate2 = "SELECT uservalidate2 FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
	$resultuservalidate2 = mysqli_query($db, $queryuservalidate2);
	while ($row = $resultuservalidate2->fetch_assoc()) {
    		$uservalidate2 = $row['uservalidate2'];
	}

	$queryuservalidate3 = "SELECT uservalidate3 FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
	$resultuservalidate3 = mysqli_query($db, $queryuservalidate3);
	while ($row = $resultuservalidate3->fetch_assoc()) {
    		$uservalidate3 = $row['uservalidate3'];
	}

	$queryuservalidate4 = "SELECT uservalidate4 FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
	$resultuservalidate4 = mysqli_query($db, $queryuservalidate4);
	while ($row = $resultuservalidate4->fetch_assoc()) {
    		$uservalidate4 = $row['uservalidate4'];
	}

	$queryvalidated = "SELECT validated FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
        $resultvalidated = mysqli_query($db, $queryvalidated);
        while ($row = $resultvalidated->fetch_assoc()) {
                $validated = $row['validated'];
        }

	if ($uservalidate1 == "0") {
		$querysetvalidate1 = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET uservalidate1 = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
		$resultsetvalidate1 = mysqli_query($db, $querysetvalidate1);
		#Message when first validation of the pending strike is done
		echo "Validation 1 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch drei Validierungen!";

	} elseif ($uservalidate2 == "0") {
		$querysetvalidate2 = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET uservalidate2 = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
                $resultsetvalidate2 = mysqli_query($db, $querysetvalidate2);
		#Message when second validation of the pending strike is done	
		echo "Validation 2 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch zwei Validierungen!";

	} elseif ($uservalidate3 == "0") {
                $querysetvalidate3 = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET uservalidate3 = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
                $resultsetvalidate3 = mysqli_query($db, $querysetvalidate3);
                #Message when second validation of the pending strike is done
                echo "Validation 3 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlt noch eine Validierung!";

	} elseif ($uservalidate4 == "0") {
                $querysetvalidate4 = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET uservalidate4 = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
                $resultsetvalidate4 = mysqli_query($db, $querysetvalidate4);

                $queryaddstrike = "UPDATE current_strikes INNER JOIN pending_strikes_add ON current_strikes.userid = pending_strikes_add.userid INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET currentstrikes = currentstrikes+1; ";
                $resultaddstrike = mysqli_query($db, $queryaddstrike);

                $queryvalidatepsa ="UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validated = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
                $resultvalidatepsa = mysqli_query($db, $queryvalidatepsa);
                #Message when third/final validation of the pending strike is done
                echo "Validation 4 wurde mit dem Code $valcode erfolgreich durchgeführt! Der Strike wurde erfolgreich validiert!";

	} else {
		if ($validated) {
		#Message when pending strike is already validated
		echo "Zu langsam... Strike wurde bereits validiert!";
		}
	}

	$querydelcode = "DELETE FROM validate_strikes_add WHERE code LIKE '$valcode';";
        $resultdelcode = mysqli_query($db, $querydelcode);

	}
?>
