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

	$querycodeexisting = "SELECT id FROM validate_del_strikes_add WHERE code = ?;";
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
		$querypsaid = "SELECT pending_strikes_add.id FROM pending_strikes_add INNER JOIN pending_del_strikes_add ON pending_strikes_add.id = pending_del_strikes_add.psaid INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid WHERE validate_del_strikes_add.code = ?;";
		$preppsaid = mysqli_prepare($db, $querypsaid);
		mysqli_stmt_bind_param ($preppsaid, 's', $valcode);
		mysqli_stmt_execute($preppsaid);
		$resultpsaid = mysqli_stmt_get_result($preppsaid);

		while ($row = $resultpsaid->fetch_assoc()) {
    			$psaid = $row['id'];
		}

		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_del_strikes_add INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid WHERE validate_del_strikes_add.code = ?;";
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

			$querydelcode = "DELETE FROM validate_del_strikes_add WHERE code = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_del_strikes_add INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_add.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code " . htmlspecialchars($valcode) . " erfolgreich durchgeführt! Es fehlen noch " . htmlspecialchars($validations_left) . " Validierungen!";

		                $querydelcode = "DELETE FROM validate_del_strikes_add WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

			} elseif ($validations_left == "1") {
		                $querysetvalidations_acc = "UPDATE pending_del_strikes_add INNER JOIN validate_del_strikes_add ON pending_del_strikes_add.id = validate_del_strikes_add.pdsaid SET validations_acc = validations_acc + 1 WHERE validate_del_strikes_add.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

        		        $querydelvalstrikedel = "DELETE FROM validate_strikes_add WHERE psaid = ?;";
				$prepdelvalstrikedel = mysqli_prepare($db, $querydelvalstrikedel);
				mysqli_stmt_bind_param ($prepdelvalstrikedel, 'i', $psaid);
				mysqli_stmt_execute($prepdelvalstrikedel);
				$resultdelvalstrikedel = mysqli_stmt_get_result($prepdelvalstrikedel);

				$querydelcode = "DELETE FROM validate_del_strikes_add WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

		                $querydelpendingdelstrikeadd = "UPDATE pending_del_strikes_add SET validated = '1' WHERE psaid = ?;";
				$prepdelpendingdelstrikeadd = mysqli_prepare($db, $querydelpendingdelstrikeadd);
				mysqli_stmt_bind_param ($prepdelpendingdelstrikeadd, 'i', $psaid);
				mysqli_stmt_execute($prepdelpendingdelstrikeadd);
				$resultdelpendingdelstrikeadd = mysqli_stmt_get_result($prepdelpendingdelstrikeadd);

                		$querydelpendingstrike = "UPDATE pending_strikes_add psa INNER JOIN pending_del_strikes_add pdsa ON psa.id = pdsa.psaid SET deleted = '1' WHERE psa.id = ?;";
				$prepdelpendingstrike = mysqli_prepare($db, $querydelpendingstrike);
				mysqli_stmt_bind_param ($prepdelpendingstrike, 'i', $psaid);
				mysqli_stmt_execute($prepdelpendingstrike);
				$resultdelpendingstrike = mysqli_stmt_get_result($prepdelpendingstrike);

                		echo "Validation wurde mit dem Code " . htmlspecialchars($valcode) . " erfolgreich durchgeführt! Alle " . htmlspecialchars($validations_needed . " Validationen sind erfolgt. Der Strike-Add wurde erfolgreich abgebrochen!";
			}
		}			
	}
?>
