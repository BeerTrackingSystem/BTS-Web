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
	else
	{
		$querypsdid = "SELECT pending_strikes_del.id FROM pending_strikes_del INNER JOIN pending_del_strikes_del ON pending_strikes_del.id = pending_del_strikes_del.psdid INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
		$resultpsdid = mysqli_query($db, $querypsdid);
		while ($row = $resultpsdid->fetch_assoc()) {
    			$psdid = $row['id'];
		}

		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code LIKE '$valcode';";
		$resultdata = mysqli_query($db, $querydata);
                while ($row = $resultdata->fetch_assoc()) {
                        $validated = $row['validated'];
                        $validations_needed = $row['validations_needed'];
                        $validations_acc = $row['validations_acc'];
                }
                $validations_left = abs($validations_needed - $validations_acc);


		if ($validated) {
			#Message when pending strike is already validated
			echo "Zu langsam... Strike wurde bereits validiert!";

			$querydelcode = "DELETE FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
               		$resultdelcode = mysqli_query($db, $querydelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_del.code LIKE '$valcode';";
				$resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);

				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch $validations_left Validierungen!";

		                $querydelcode = "DELETE FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
        		        $resultdelcode = mysqli_query($db, $querydelcode);

			} elseif ($validations_left == "1") {
		                $querysetvalidations_acc = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_del.code LIKE '$valcode';";
		                $resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);

        		        $querydelvalstrikedel = "DELETE FROM validate_strikes_del WHERE psdid LIKE '$psdid';";
               			$resultdelvalstrikedel = mysqli_query($db, $querydelvalstrikedel);

				$querydelcode = "DELETE FROM validate_del_strikes_del WHERE code LIKE '$valcode';";
	        		$resultdelcode = mysqli_query($db, $querydelcode);

		                $querydelpendingdelstrikedel = "DELETE FROM pending_del_strikes_del WHERE psdidid LIKE '$psdid';";
		                $resultdelpendingdelstrikedel = mysqli_query($db, $querydelpendingdelstrikedel);

                		$querydelpendingstrike = "DELETE FROM pending_strikes_del WHERE id LIKE '$psdid';";
		                $resultdelpendingstrike = mysqli_query($db, $querydelpendingstrike);

                		echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Alle $validations_needed Validationen sind erfolgt. Die Entfernung der Strikes wurde erfolgreich abgebrochen!";

			}
		}			
	}
?>
