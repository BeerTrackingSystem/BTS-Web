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
	else
	{
		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code LIKE '$valcode';";
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
	
			$querydelcode = "DELETE FROM validate_strikes_del WHERE code LIKE '$valcode';";
	        	$resultdelcode = mysqli_query($db, $querydelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validations_acc = validations_acc + 1 WHERE validate_strikes_del.code LIKE '$valcode';";
                		$resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);
				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch $validations_left Validierungen!";

				$querydelcode = "DELETE FROM validate_strikes_del WHERE code LIKE '$valcode';";
	        		$resultdelcode = mysqli_query($db, $querydelcode);
	
			} elseif ($validations_left == "1") {
				 $querysetvalidations_acc = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validations_acc = validations_acc + 1 WHERE validate_strikes_del.code LIKE '$valcode';";
				 $resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);

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
		                echo "Validation 4 wurde mit dem Code $valcode erfolgreich durchgeführt! Die Strike-Löschung wurde erfolgreich validiert!";

				$querydelcode = "DELETE FROM validate_strikes_del WHERE code LIKE '$valcode';";
	        		$resultdelcode = mysqli_query($db, $querydelcode);
			}	
		}
	}
?>
