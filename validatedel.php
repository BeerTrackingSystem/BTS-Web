<?php
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];
	$querycodeexisting = "SELECT id FROM validate_strikes_del WHERE code LIKE '$valcode';";
        $resultcodeexisting = mysqli_query($db, $querycodeexisting);
	

	if(mysqli_num_rows($resultcodeexisting) == "0") {
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

	$queryvalidated = "SELECT validated FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
        $resultvalidated = mysqli_query($db, $queryvalidated);
        while ($row = $resultvalidated->fetch_assoc()) {
                $validated = $row['validated'];
        }

	if ($uservalidate1 == "0") {
		$querysetvalidate1 = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET uservalidate1 = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
		$resultsetvalidate1 = mysqli_query($db, $querysetvalidate1);
		echo "Validation 1 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlt noch eine Validierung!";
	} elseif ($uservalidate2 == "0") {
		$querysetvalidate2 = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET uservalidate2 = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
                $resultsetvalidate2 = mysqli_query($db, $querysetvalidate2);

		$querydelstrike ="UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.id = pending_strikes_del.userid SET currentstrikes = currentstrikes-5;";
     		$resultdelstrike = mysqli_query($db, $querydelstrike);

		$queryvalidatepsd ="UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validated = '1' WHERE validate_strikes_del.code LIKE '$valcode';";
     		$resultvalidatepsd = mysqli_query($db, $queryvalidatepsd);
			
		echo "Validation 2 wurde mit dem Code $valcode erfolgreich durchgeführt! Der Strike wurde erfolgreich validiert!";
	} else {
		if ($validated) {
		echo "Zu langsam... Strike wurde bereits validiert!";
		}
	}

	$querydelcode = "DELETE FROM validate_strikes_del WHERE code LIKE '$valcode';";
        $resultdelcode = mysqli_query($db, $querydelcode);

	}
?>
