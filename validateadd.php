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

	$querycodeexisting = "SELECT id FROM validate_strikes_add WHERE code = ?;";
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
		$querydata = "SELECT validations_needed, validations_acc, validated FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code = ?;";
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
	
			$querydelcode = "DELETE FROM validate_strikes_add WHERE code = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);
		}
		else
		{
			if ($validations_left > "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validations_acc = validations_acc + 1 WHERE validate_strikes_add.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

				$validations_left = $validations_left - 1;
				echo "Validation wurde mit dem Code " . htmlspecialchars($valcode) . " erfolgreich durchgeführt! Es fehlen noch " . htmlspecialchars($validations_left) . " Validierungen!";

				$querydelcode = "DELETE FROM validate_strikes_add WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);
	
			} elseif ($validations_left == "1") {
				$querysetvalidations_acc = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validations_acc = validations_acc + 1 WHERE validate_strikes_add.code = ?;";
				$prepsetvalidations_acc = mysqli_prepare($db, $querysetvalidations_acc);
				mysqli_stmt_bind_param ($prepsetvalidations_acc, 's', $valcode);
				mysqli_stmt_execute($prepsetvalidations_acc);
				$resultsetvalidations_acc = mysqli_stmt_get_result($prepsetvalidations_acc);

				$queryeventstatus = "SELECT event FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code = ?;";
				$prepeventstatus = mysqli_prepare($db, $queryeventstatus);
				mysqli_stmt_bind_param ($prepeventstatus, 's', $valcode);
				mysqli_stmt_execute($prepeventstatus);
				$resulteventstatus = mysqli_stmt_get_result($prepeventstatus);
				$eventstatus =  mysqli_fetch_array($resulteventstatus);
	
				$querystrikeamounts = "SELECT value AS amount_normal, (SELECT value AS amount_normal FROM misc WHERE object = 'strike_add' AND ATTRIBUTE = 'amount_event') AS amount_event FROM misc WHERE object = 'strike_add' AND ATTRIBUTE = 'amount_normal';";
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

	               		$queryaddstrike = "UPDATE current_strikes INNER JOIN pending_strikes_add ON current_strikes.userid = pending_strikes_add.userid INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET currentstrikes = currentstrikes + ?;";
				$prepaddstrike = mysqli_prepare($db, $queryaddstrike);
				mysqli_stmt_bind_param ($prepaddstrike, 'i', $amount);
				mysqli_stmt_execute($prepaddstrike);
				$resultaddstrike = mysqli_stmt_get_result($prepaddstrike);
	
	                	$queryvalidatepsa ="UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid SET validated = '1' WHERE validate_strikes_add.code = ?;";
				$prepvalidatepsa = mysqli_prepare($db, $queryvalidatepsa);
				mysqli_stmt_bind_param ($prepvalidatepsa, 's', $valcode);
				mysqli_stmt_execute($prepvalidatepsa);
				$resultvalidatepsa = mysqli_stmt_get_result($prepvalidatepsa);

       		         	#Message when third/final validation of the pending strike is done
       		         	echo "Validation wurde mit dem Code " . htmlspecialchars($valcode) . " erfolgreich durchgeführt! Alle " . htmlspecialchars($validations_needed) . " Validationen sind erfolgt. Der Strike wurde erfolgreich validiert!";

				$querydeladdcodedel = "DELETE vdsa FROM validate_del_strikes_add vdsa INNER JOIN pending_del_strikes_add pdsa ON pdsa.id = vdsa.pdsaid INNER JOIN validate_strikes_add vsa ON pdsa.psaid = vsa.psaid WHERE vsa.code = ?;";
				$prepdeladdcodedel = mysqli_prepare($db, $querydeladdcodedel);
				mysqli_stmt_bind_param ($prepdeladdcodedel, 's', $valcode);
				mysqli_stmt_execute($prepdeladdcodedel);
				$resultdeladdcodedel = mysqli_stmt_get_result($prepdeladdcodedel);

                                $querydeladdstrikedel = "DELETE pdsa FROM pending_del_strikes_add pdsa INNER JOIN validate_strikes_add vsa ON pdsa.psaid = vsa.psaid WHERE vsa.code = ?;";
				$prepdeladdstrikedel = mysqli_prepare($db, $querydeladdstrikedel);
				mysqli_stmt_bind_param ($prepdeladdstrikedel, 's', $valcode);
				mysqli_stmt_execute($prepdeladdstrikedel);
				$resultdeladdstrikedel = mysqli_stmt_get_result($prepdeladdstrikedel);

				$querydelcode = "DELETE FROM validate_strikes_add WHERE code = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 's', $valcode);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);
			}	
		}
	}
?>
