<?php
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];
	$querycodeexisting = "SELECT id FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
        $resultcodeexisting = mysqli_query($db, $querycodeexisting);
	
	if(mysqli_num_rows($resultcodeexisting) == "0") {
		#Message when someone already used his validation link
		echo "Obacht... Du hast schon auf den Link geklickt...";
	}

	$querypsdid = "SELECT pending_strikes_del.id FROM pending_strikes_del INNER JOIN pending_del_strikes_del ON pending_strikes_del.id = pending_del_strikes_del.psdid INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
	$resultpsdid = mysqli_query($db, $querypsdid);
	while ($row = $resultpsdid->fetch_assoc()) {
    		$psdid = $row['id'];
	}

	if(mysqli_num_rows($resultcodeexisting) !== "0") {
	$queryuservalidate1 = "SELECT uservalidate1 FROM pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
	$resultuservalidate1 = mysqli_query($db, $queryuservalidate1);
	while ($row = $resultuservalidate1->fetch_assoc()) {
    		$uservalidate1 = $row['uservalidate1'];
	}

	$queryuservalidate2 = "SELECT uservalidate2 FROM pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
	$resultuservalidate2 = mysqli_query($db, $queryuservalidate2);
	while ($row = $resultuservalidate2->fetch_assoc()) {
    		$uservalidate2 = $row['uservalidate2'];
	}

	$queryuservalidate3 = "SELECT uservalidate3 FROM pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
	$resultuservalidate3 = mysqli_query($db, $queryuservalidate3);
	while ($row = $resultuservalidate3->fetch_assoc()) {
    		$uservalidate3 = $row['uservalidate3'];
	}

	$queryvalidated = "SELECT validated FROM pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
        $resultvalidated = mysqli_query($db, $queryvalidated);
        while ($row = $resultvalidated->fetch_assoc()) {
                $validated = $row['validated'];
        }

	if ($uservalidate1 == "0") {
		$querysetvalidate1 = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET uservalidate1 = '1' WHERE validate_del_strikes_del.code LIKE '$valcode';";
		$resultsetvalidate1 = mysqli_query($db, $querysetvalidate1);
		#Message when first validation of the pending strike is done
		echo "Validation 1 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch zwei Validierungen!";

                $querydelcode = "DELETE FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
                $resultdelcode = mysqli_query($db, $querydelcode);

	} elseif ($uservalidate2 == "0") {
		$querysetvalidate2 = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET uservalidate2 = '1' WHERE validate_del_strikes_del.code LIKE '$valcode';";
                $resultsetvalidate2 = mysqli_query($db, $querysetvalidate2);
		#Message when second validation of the pending strike is done	
		echo "Validation 2 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlt noch eine Validierung!";

		$querydelcode = "DELETE FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
        	$resultdelcode = mysqli_query($db, $querydelcode);

	} elseif ($uservalidate3 == "0") {
                $querysetvalidate3 = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET uservalidate3 = '1' WHERE validate_del_strikes_del.code LIKE '$valcode';";
                $resultsetvalidate3 = mysqli_query($db, $querysetvalidate3);
		

                $querydelvalstrikedel = "DELETE FROM validate_strikes_del WHERE psdid LIKE '$psdid';";
                $resultdelvalstrikedel = mysqli_query($db, $querydelvalstrikedel);

		$querydelcode = "DELETE FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
        	$resultdelcode = mysqli_query($db, $querydelcode);

                $querydelpendingdelstrikedel = "DELETE FROM pending_del_strikes_del WHERE psdid LIKE '$psdid';";
                $resultdelpendingdelstrikedel = mysqli_query($db, $querydelpendingdelstrikedel);

                $querydelpendingstrike = "DELETE FROM pending_strikes_del WHERE id LIKE '$psdid';";
                $resultdelpendingstrike = mysqli_query($db, $querydelpendingstrike);

                #Message when third/final validation of the pending strike is done
                echo "Validation 3 wurde mit dem Code $valcode erfolgreich durchgeführt! Der Strike wurde erfolgreich validiert!";

	} else {
		if ($validated) {
		#Message when pending strike is already validated
		echo "Zu langsam... Strike wurde bereits validiert!";
		}
	}
	}
?>
