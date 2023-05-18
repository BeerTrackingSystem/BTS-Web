<?php
if (!isset($_GET['valcode']))
{
	http_response_code(404);
	die();
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];

	$querycodeexisting = "SELECT id FROM validate_strikes_del WHERE code = ?;";
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
		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code = ?;";
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
	
			$querydelcode = "DELETE FROM validate_strikes_del WHERE code = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validations_acc = validations_acc + 1 WHERE validate_strikes_del.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code " . htmlspecialchars($valcode) . " erfolgreich durchgeführt! Es fehlen noch " . htmlspecialchars($validations_left) . " Validierungen!";

				$querydelcode = "DELETE FROM validate_strikes_del WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);
	
			} elseif ($validations_left == "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validations_acc = validations_acc + 1 WHERE validate_strikes_del.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

				$queryeventstatus = "SELECT event FROM pending_strikes_del INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code = ?;";
				$prepeventstatus = mysqli_prepare($db, $queryeventstatus);
				mysqli_stmt_bind_param ($prepeventstatus, 's', $valcode);
				mysqli_stmt_execute($prepeventstatus);
				$resulteventstatus = mysqli_stmt_get_result($prepeventstatus);
                                $eventstatus =  mysqli_fetch_array($resulteventstatus);

                                $querystrikeamounts = "SELECT value AS amount_normal, (SELECT value AS amount_normal FROM misc WHERE object = 'strike_del' AND ATTRIBUTE = 'amount_event') AS amount_event FROM misc WHERE object = 'strike_del' AND ATTRIBUTE = 'amount_normal';";
                                $resultstrikeamounts = mysqli_query($db, $querystrikeamounts);
                                $strikeamounts =  mysqli_fetch_array($resultstrikeamounts);

                                if ($eventstatus['event'] == true)
                                {
                                        $amount = $strikeamounts['amount_event'];
                                }
                                else
                                {
                                        $amount = $strikeamounts['amount_normal'];
                                }

				$querycurrentstrikes = "Select currentstrikes FROM current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid WHERE validate_strikes_del.code = ?;";
				$prepcurrentstrikes = mysqli_prepare($db, $querycurrentstrikes);
				mysqli_stmt_bind_param ($prepcurrentstrikes, 's', $valcode);
				mysqli_stmt_execute($prepcurrentstrikes);
				$resultcurrentstrikes = mysqli_stmt_get_result($prepcurrentstrikes);
		                while ($row = $resultcurrentstrikes->fetch_assoc()) {
                		        $currentstrikes = $row['currentstrikes'];
                		}

                		if ($currentstrikes >= $amount){
		                        $querydelstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid SET currentstrikes = currentstrikes - ? WHERE validate_strikes_del.code = ?;";
					$prepdelstrike = mysqli_prepare($db, $querydelstrike);
					mysqli_stmt_bind_param ($prepdelstrike, 'is', $amount, $valcode);
					mysqli_stmt_execute($prepdelstrike);
					$resultdelstrike = mysqli_stmt_get_result($prepdelstrike);
                		}
                		else {
		                        $querydelremainingstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid SET currentstrikes = '0' WHERE validate_strikes_del.code = ?;";
					$prepdelremainingstrike = mysqli_prepare($db, $querydelremainingstrike);
					mysqli_stmt_bind_param ($prepdelremainingstrike, 's', $valcode);
					mysqli_stmt_execute($prepdelremainingstrike);
					$resultdelremainingstrike = mysqli_stmt_get_result($prepdelremainingstrike);
                		}

				$queryupdatelastpay = "UPDATE user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid INNER JOIN validate_strikes_del ON pending_strikes_del.id = validate_strikes_del.psdid SET last_pay = curdate() WHERE validate_strikes_del.code = ?;";
				$prepupdatelastpay = mysqli_prepare($db, $queryupdatelastpay);
				mysqli_stmt_bind_param ($prepupdatelastpay, 's', $valcode);
				mysqli_stmt_execute($prepupdatelastpay);
				$resultupdatelastpay = mysqli_stmt_get_result($prepupdatelastpay);

                		$queryvalidatepsd ="UPDATE pending_strikes_del INNER JOIN validate_strikes_del ON  pending_strikes_del.id = validate_strikes_del.psdid SET validated = '1' WHERE validate_strikes_del.code = ?;";
				$prepvalidatepsd = mysqli_prepare($db, $queryvalidatepsd);
				mysqli_stmt_bind_param ($prepvalidatepsd, 's', $valcode);
				mysqli_stmt_execute($prepvalidatepsd);
				$resultvalidatepsd = mysqli_stmt_get_result($prepvalidatepsd);

                		#Message when third/final validation of the pending strike is done
		                echo "Validation wurde mit dem Code " . htmlspecialchars($valcode) . " erfolgreich durchgeführt! Die Strike-Löschung wurde erfolgreich validiert!";

			 	$querydeldelcodedel = "DELETE vdsd FROM validate_del_strikes_del vdsd INNER JOIN pending_del_strikes_del pdsd ON pdsd.id = vdsd.pdsdid INNER JOIN validate_strikes_del vsd ON pdsd.psdid = vsd.psdid WHERE vsd.code = ?;";
				$prepdeldelcodedel = mysqli_prepare($db, $querydeldelcodedel);
				mysqli_stmt_bind_param ($prepdeldelcodedel, 's', $valcode);
				mysqli_stmt_execute($prepdeldelcodedel);
				$resultdeldelcodedel = mysqli_stmt_get_result($prepdeldelcodedel);

                                $querydeldelstrikedel = "DELETE pdsd FROM pending_del_strikes_del pdsd INNER JOIN validate_strikes_del vsd ON pdsd.psdid = vsd.psdid WHERE vsd.code = ?;";
				$prepdeldelstrikedel = mysqli_prepare($db, $querydeldelstrikedel);
				mysqli_stmt_bind_param ($prepdeldelstrikedel, 's', $valcode);
				mysqli_stmt_execute($prepdeldelstrikedel);
				$resultdeldelstrikedel = mysqli_stmt_get_result($prepdeldelstrikedel);

				$querydelcode = "DELETE FROM validate_strikes_del WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);
			}	
		}
	}
?>
