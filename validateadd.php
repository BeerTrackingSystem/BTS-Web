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
	else
	{
		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
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
	
			$querydelcode = "DELETE FROM validate_strikes_add WHERE code LIKE '$valcode';";
	        	$resultdelcode = mysqli_query($db, $querydelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validations_acc = validations_acc + 1 WHERE validate_strikes_add.code LIKE '$valcode';";
				$resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);
				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch $validations_left Validierungen!";

				$querydelcode = "DELETE FROM validate_strikes_add WHERE code LIKE '$valcode';";
	        		$resultdelcode = mysqli_query($db, $querydelcode);
	
			} elseif ($validations_left == "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validations_acc = validations_acc + 1 WHERE validate_strikes_add.code LIKE '$valcode';";
				$resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);
	
	               		$queryaddstrike = "UPDATE current_strikes INNER JOIN pending_strikes_add ON current_strikes.userid = pending_strikes_add.userid INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET currentstrikes = currentstrikes+1; ";
				$resultaddstrike = mysqli_query($db, $queryaddstrike);
	
	                	$queryvalidatepsa ="UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validated = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
       		         	$resultvalidatepsa = mysqli_query($db, $queryvalidatepsa);
       		         	#Message when third/final validation of the pending strike is done
       		         	echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Alle $validations_needed Validationen sind erfolgt. Der Strike wurde erfolgreich validiert!";

				$querydeladdcodedel = "DELETE vdsa FROM validate_del_strikes_add vdsa INNER JOIN pending_del_strikes_add pdsa ON pdsa.id = vdsa.pdsaid INNER JOIN validate_strikes_add vsa ON pdsa.psaid = vsa.psaid WHERE vsa.code LIKE '$valcode';";
                                $resultdeladdcodedel = mysqli_query($db, $querydeladdcodedel);

                                $querydeladdstrikedel = "DELETE pdsa FROM pending_del_strikes_add pdsa INNER JOIN validate_strikes_add vsa ON pdsa.psaid = vsa.psaid WHERE vsa.code LIKE '$valcode';";
                                $resultdeladdstrikedel = mysqli_query($db, $querydeladdstrikedel);

				$querydelcode = "DELETE FROM validate_strikes_add WHERE code LIKE '$valcode';";
	        		$resultdelcode = mysqli_query($db, $querydelcode);
			}	
		}
	}
?>
