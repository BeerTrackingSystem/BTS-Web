<?php
if (!isset($_GET['valcode']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];

	$querycodeexisting = "SELECT id FROM validate_del_strikes_del WHERE code = ?;";
	$prepcodeexisting = mysqli_prepare($db, $querycodeexisting);
	mysqli_stmt_bind_param ($prepcodeexisting, 's', $valcode);
	mysqli_stmt_execute($prepcodeexisting);
	$resultcodeexisting = mysqli_stmt_get_result($prepcodeexisting);
	
	if(mysqli_num_rows($resultcodeexisting) == "0") {
		#Message when someone already used his validation link
		echo "Obacht... Du hast schon auf den Link geklickt...";
	}
	else
	{
		$querypsdid = "SELECT pending_strikes_del.id FROM pending_strikes_del INNER JOIN pending_del_strikes_del ON pending_strikes_del.id = pending_del_strikes_del.psdid INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code = ?;";
		$preppsdid = mysqli_prepare($db, $querypsdid);
		mysqli_stmt_bind_param ($preppsdid, 's', $valcode);
		mysqli_stmt_execute($preppsdid);
		$resultpsdid = mysqli_stmt_get_result($preppsdid);


		while ($row = $resultpsdid->fetch_assoc()) {
    			$psdid = $row['id'];
		}

		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid WHERE validate_del_strikes_del.code = ?;";
		$prepdata = mysqli_prepare($db, $querydata);
		mysqli_stmt_bind_param ($prepdata, 's', $valcode);
		mysqli_stmt_execute($prepdata);
		$resultdata = mysqli_stmt_get_result($prepdata);

                while ($row = $resultdata->fetch_assoc()) {
                        $validated = $row['validated'];
                        $validations_needed = $row['validations_needed'];
                        $validations_acc = $row['validations_acc'];
                }
                $validations_left = abs($validations_needed - $validations_acc);

		if ($validated) {
			#Message when pending strike is already validated
			echo "Zu langsam... Strike wurde bereits validiert!";

			$querydelcode = "DELETE FROM validate_del_strikes_del WHERE code = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_del.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlen noch $validations_left Validierungen!";

		                $querydelcode = "DELETE FROM validate_del_strikes_del WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

			} elseif ($validations_left == "1") {
		                $querysetvalidations_acc = "UPDATE pending_del_strikes_del INNER JOIN validate_del_strikes_del ON pending_del_strikes_del.id = validate_del_strikes_del.pdsdid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_del.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

        		        $querydelvalstrikedel = "DELETE FROM validate_strikes_del WHERE psdid = ?;";
				$prepdelvalstrikedel = mysqli_prepare($db, $querydelvalstrikedel);
				mysqli_stmt_bind_param ($prepdelvalstrikedel, 'i', $psdid);
				mysqli_stmt_execute($prepdelvalstrikedel);
				$resultdelvalstrikedel = mysqli_stmt_get_result($prepdelvalstrikedel);

				$querydelcode = "DELETE FROM validate_del_strikes_del WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

		                $querydelpendingdelstrikedel = "UPDATE pending_del_strikes_del SET validated = '1' WHERE psdid = ?;";
				$prepdelpendingdelstrikedel = mysqli_prepare($db, $querydelpendingdelstrikedel);
				mysqli_stmt_bind_param ($prepdelpendingdelstrikedel, 'i', $psdid);
				mysqli_stmt_execute($prepdelpendingdelstrikedel);
				$resultdelpendingdelstrikedel = mysqli_stmt_get_result($prepdelpendingdelstrikedel);

				$querydelpendingstrike = "UPDATE pending_strikes_del psd INNER JOIN pending_del_strikes_del pdsd ON psd.id = pdsd.psdid SET deleted = '1' WHERE psd.id = ?;";
				$prepdelpendingstrike = mysqli_prepare($db, $querydelpendingstrike);
				mysqli_stmt_bind_param ($prepdelpendingstrike, 'i', $psdid);
				mysqli_stmt_execute($prepdelpendingstrike);
				$resultdelpendingstrike = mysqli_stmt_get_result($prepdelpendingstrike);

                		echo "Validation wurde mit dem Code $valcode erfolgreich durchgeführt! Alle $validations_needed Validationen sind erfolgt. Der Strike-Del wurde erfolgreich abgebrochen!";

			}
		}			
	}
?>
