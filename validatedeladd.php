<?php
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];
	$querycodeexisting = "SELECT id FROM validate_del_strikes_add WHERE code LIKE '$valcode';";
        $resultcodeexisting = mysqli_query($db, $querycodeexisting);
	
	if(mysqli_num_rows($resultcodeexisting) == "0") {
		#Message when someone already used his validation link
		echo "Obacht... Du hast schon auf den Link geklickt...";
	}
	else
	{
		$querypsaid = "SELECT pending_strikes_add.id FROM pending_strikes_add INNER JOIN pending_del_strikes_add ON pending_strikes_add.id = pending_del_strikes_add.psaid INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid WHERE validate_del_strikes_add.code LIKE '$valcode';";
		$resultpsaid = mysqli_query($db, $querypsaid);
		while ($row = $resultpsaid->fetch_assoc()) {
    			$psaid = $row['id'];
		}

		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_del_strikes_add INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid WHERE validate_del_strikes_add.code LIKE '$valcode';";
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

			$querydelcode = "DELETE FROM validate_del_strikes_add WHERE code LIKE '$valcode';";
               		$resultdelcode = mysqli_query($db, $querydelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_del_strikes_add INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_add.code LIKE '$valcode';";
				$resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);

				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch $validations_left Validierungen!";

		                $querydelcode = "DELETE FROM validate_del_strikes_add WHERE code LIKE '$valcode';";
        		        $resultdelcode = mysqli_query($db, $querydelcode);

			} elseif ($validations_left == "1") {
		                $querysetvalidations_acc = "UPDATE pending_del_strikes_add INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_add.code LIKE '$valcode';";
		                $resultsetvalidations_acc = mysqli_query($db, $querysetvalidations_acc);

        		        $querydelvalstrikedel = "DELETE FROM validate_strikes_add WHERE psaid LIKE '$psaid';";
               			$resultdelvalstrikedel = mysqli_query($db, $querydelvalstrikedel);

				$querydelcode = "DELETE FROM validate_del_strikes_add WHERE code LIKE '$valcode';";
	        		$resultdelcode = mysqli_query($db, $querydelcode);

		                $querydelpendingdelstrikeadd = "UPDATE pending_del_strikes_add SET validated = '1' WHERE psaid LIKE '$psaid';";
		                $resultdelpendingdelstrikeadd = mysqli_query($db, $querydelpendingdelstrikeadd);

                		$querydelpendingstrike = "UPDATE pending_strikes_add psa INNER JOIN pending_del_strikes_add pdsa ON psa.id = pdsa.psaid SET deleted = '1' WHERE psa.id LIKE '$psaid';";
		                $resultdelpendingstrike = mysqli_query($db, $querydelpendingstrike);

                		echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Alle $validations_needed Validationen sind erfolgt. Der Strike-Add wurde erfolgreich abgebrochen!";

			}
		}			
	}
?>
