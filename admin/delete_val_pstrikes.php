<?php
if (empty($_POST['pastrikes']) && empty($_POST['pdstrikes']) && empty($_POST['pdastrikes']) && empty($_POST['pddstrikes']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$pastrikeid = $_POST['pastrikes'];
	$pdstrikeid = $_POST['pdstrikes'];
	$pdastrikeid = $_POST['pdastrikes'];
	$pddstrikeid = $_POST['pddstrikes'];

	$workflow = $_POST['submit'];


	if ( $workflow == 'Validate')
	{
		if ( $pastrikeid != 'blank')
		{
                                $queryaddstrike = "UPDATE current_strikes INNER JOIN pending_strikes_add ON current_strikes.userid = pending_strikes_add.userid SET currentstrikes = currentstrikes+1 WHERE pending_strikes_add.id = ?;";
				$prepaddstrike = mysqli_prepare($db, $queryaddstrike);
				mysqli_stmt_bind_param ($prepaddstrike, 'i', $pastrikeid);
				mysqli_stmt_execute($prepaddstrike);
				$resultaddstrike = mysqli_stmt_get_result($prepaddstrike);

                                $queryvalidatepsa ="UPDATE pending_strikes_add SET validated = '1' WHERE id = ?;";
				$prepvalidatepsa = mysqli_prepare($db, $queryvalidatepsa);
				mysqli_stmt_bind_param ($prepvalidatepsa, 'i', $pastrikeid);
				mysqli_stmt_execute($prepvalidatepsa);
				$resultvalidatepsa = mysqli_stmt_get_result($prepvalidatepsa);

                                #Message when third/final validation of the pending strike is done
				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Der Strike wurde erfolgreich validiert!') </script>";

                                $querydelcode = "DELETE FROM validate_strikes_add WHERE psaid = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 'i', $pastrikeid);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

                                $querydeladdcodedel = "DELETE vdsa FROM validate_del_strikes_add vdsa INNER JOIN pending_del_strikes_add pdsa ON pdsa.id = vdsa.pdsaid WHERE pdsa.psaid = ?;";
				$prepdeladdcodedel = mysqli_prepare($db, $querydeladdcodedel);
				mysqli_stmt_bind_param ($prepdeladdcodedel, 'i', $pastrikeid);
				mysqli_stmt_execute($prepdeladdcodedel);
				$resultdeladdcodedel = mysqli_stmt_get_result($prepdeladdcodedel);

                                $querydeladdstrikedel = "DELETE FROM pending_del_strikes_add WHERE psaid = ?;";
				$prepdeladdstrikedel = mysqli_prepare($db, $querydeladdstrikedel);
				mysqli_stmt_bind_param ($prepdeladdstrikedel, 'i', $pastrikeid);
				mysqli_stmt_execute($prepdeladdstrikedel);
				$resultdeladdstrikedel = mysqli_stmt_get_result($prepdeladdstrikedel);
		}

		if ( $pdstrikeid != 'blank')
		{
                                $querycurrentstrikes = "Select currentstrikes FROM current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid WHERE pending_strikes_del.id = ?;";
				$prepcurrentstrikes = mysqli_prepare($db, $querycurrentstrikes);
				mysqli_stmt_bind_param ($prepcurrentstrikes, 'i', $pdstrikeid);
				mysqli_stmt_execute($prepcurrentstrikes);
				$resultcurrentstrikes = mysqli_stmt_get_result($prepcurrentstrikes);
                                while ($row = $resultcurrentstrikes->fetch_assoc()) {
                                        $currentstrikes = $row['currentstrikes'];
                                }

                                if ($currentstrikes >= "5"){
                                        $querydelstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid SET currentstrikes = currentstrikes-5 WHERE pending_strikes_del.id = ?;";
					$prepdelstrike = mysqli_prepare($db, $querydelstrike);
					mysqli_stmt_bind_param ($prepdelstrike, 'i', $pdstrikeid);
					mysqli_stmt_execute($prepdelstrike);
					$resultdelstrike = mysqli_stmt_get_result($prepdelstrike);
                                }
                                else {
                                        $querydelremainingstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid SET currentstrikes = '0' WHERE pending_strikes_del.id = ?;";
					$prepdelremainingstrike = mysqli_prepare($db, $querydelremainingstrike);
					mysqli_stmt_bind_param ($prepdelremainingstrike, 'i', $pdstrikeid);
					mysqli_stmt_execute($prepdelremainingstrike);
					$resultdelremainingstrike = mysqli_stmt_get_result($prepdelremainingstrike);
                                }

                                $queryvalidatepsd ="UPDATE pending_strikes_del SET validated = '1' WHERE id = ?;";
				$prepvalidatepsd = mysqli_prepare($db, $queryvalidatepsd);
				mysqli_stmt_bind_param ($prepvalidatepsd, 'i', $pdstrikeid);
				mysqli_stmt_execute($prepvalidatepsd);
				$resultvalidatepsd = mysqli_stmt_get_result($prepvalidatepsd);

                                #Message when third/final validation of the pending strike is done
				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Die Strike-Löschung wurde erfolgreich validiert!') </script>";

                                $querydelcode = "DELETE FROM validate_strikes_del WHERE psdid = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 'i', $pdstrikeid);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

				$querydeldelcodedel = "DELETE vdsd FROM validate_del_strikes_del vdsd INNER JOIN pending_del_strikes_del pdsd ON pdsd.id = vdsd.pdsdid WHERE pdsd.psdid = ?;";
				$prepdeldelcodedel = mysqli_prepare($db, $querydeldelcodedel);
				mysqli_stmt_bind_param ($prepdeldelcodedel, 'i', $pdstrikeid);
				mysqli_stmt_execute($prepdeldelcodedel);
				$resultdeldelcodedel = mysqli_stmt_get_result($prepdeldelcodedel);

                                $querydeldelstrikedel = "DELETE FROM pending_del_strikes_del WHERE psdid = ?;";
				$prepdeldelstrikedel = mysqli_prepare($db, $querydeldelstrikedel);
				mysqli_stmt_bind_param ($prepdeldelstrikedel, 'i', $pdstrikeid);
				mysqli_stmt_execute($prepdeldelstrikedel);
				$resultdeldelstrikedel = mysqli_stmt_get_result($prepdeldelstrikedel);
		}

		if ( $pdastrikeid != 'blank')
		{
                                $querydelvalstrikedel = "DELETE vsa FROM validate_strikes_add vsa INNER JOIN pending_del_strikes_add pdsa ON vsa.psaid = pdsa.psaid WHERE pdsa.id = ?;";
				$prepdelvalstrikedel = mysqli_prepare($db, $querydelvalstrikedel);
				mysqli_stmt_bind_param ($prepdelvalstrikedel, 'i', $pdastrikeid);
				mysqli_stmt_execute($prepdelvalstrikedel);
				$resultdelvalstrikedel = mysqli_stmt_get_result($prepdelvalstrikedel);

                                $querydelcode = "DELETE FROM validate_del_strikes_add WHERE pdsaid = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 'i', $pdastrikeid);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

                                $querydelpendingdelstrikedel = "UPDATE pending_del_strikes_add SET validated = '1' WHERE id = ?;";
				$prepdelpendingdelstrikedel = mysqli_prepare($db, $querydelpendingdelstrikedel);
				mysqli_stmt_bind_param ($prepdelpendingdelstrikedel, 'i', $pdastrikeid);
				mysqli_stmt_execute($prepdelpendingdelstrikedel);
				$resultdelpendingdelstrikedel = mysqli_stmt_get_result($prepdelpendingdelstrikedel);

                                $querydelpendingstrike = "UPDATE pending_strikes_add psa INNER JOIN pending_del_strikes_add pdsa ON psa.id = pdsa.psaid SET deleted = '1' WHERE pdsa.id = ?;";
				$prepdelpendingstrike = mysqli_prepare($db, $querydelpendingstrike);
				mysqli_stmt_bind_param ($prepdelpendingstrike, 'i', $pdastrikeid);
				mysqli_stmt_execute($prepdelpendingstrike);
				$resultdelpendingstrike = mysqli_stmt_get_result($prepdelpendingstrike);

				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Der Strike-Add wurde erfolgreich abgebrochen!') </script>";
		}

		if ( $pddstrikeid != 'blank')
		{
				$querydelvalstrikedel = "DELETE vsd FROM validate_strikes_del vsd INNER JOIN pending_del_strikes_del pdsd ON vsd.psdid = pdsd.psdid WHERE pdsd.id = ?;";
				$prepdelvalstrikedel = mysqli_prepare($db, $querydelvalstrikedel);
				mysqli_stmt_bind_param ($prepdelvalstrikedel, 'i', $pddstrikeid);
				mysqli_stmt_execute($prepdelvalstrikedel);
				$resultdelvalstrikedel = mysqli_stmt_get_result($prepdelvalstrikedel);

                                $querydelcode = "DELETE FROM validate_del_strikes_del WHERE pdsdid = ?;";
				$prepdelcode = mysqli_prepare($db, $querydelcode);
				mysqli_stmt_bind_param ($prepdelcode, 'i', $pddstrikeid);
				mysqli_stmt_execute($prepdelcode);
				$resultdelcode = mysqli_stmt_get_result($prepdelcode);

                                $querydelpendingdelstrikedel = "UPDATE pending_del_strikes_del SET validated = '1' WHERE id = ?;";
				$prepdelpendingdelstrikedel = mysqli_prepare($db, $querydelpendingdelstrikedel);
				mysqli_stmt_bind_param ($prepdelpendingdelstrikedel, 'i', $pddstrikeid);
				mysqli_stmt_execute($prepdelpendingdelstrikedel);
				$resultdelpendingdelstrikedel = mysqli_stmt_get_result($prepdelpendingdelstrikedel);

                                $querydelpendingstrike = "UPDATE pending_strikes_del psd INNER JOIN pending_del_strikes_del pdsd ON psd.id = pdsd.psdid SET deleted = '1' WHERE pdsd.id = ?;";
				$prepdelpendingstrike = mysqli_prepare($db, $querydelpendingstrike);
				mysqli_stmt_bind_param ($prepdelpendingstrike, 'i', $pddstrikeid);
				mysqli_stmt_execute($prepdelpendingstrike);
				$resultdelpendingstrike = mysqli_stmt_get_result($prepdelpendingstrike);

				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Der Strike-Del wurde erfolgreich abgebrochen!') </script>";
		}
	} elseif ($workflow == 'Delete')
	{
		if ( $pastrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_strikes_add WHERE psaid = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 'i', $pastrikeid);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);

			$querydeldelcode = "DELETE vdsa FROM validate_del_strikes_add vdsa INNER JOIN pending_del_strikes_add pdsa ON pdsa.id = vdsa.pdsaid WHERE pdsa.psaid = ?;";
			$prepdeldelcode = mysqli_prepare($db, $querydeldelcode);
			mysqli_stmt_bind_param ($prepdeldelcode, 'i', $pastrikeid);
			mysqli_stmt_execute($prepdeldelcode);
			$resultdeldelcode = mysqli_stmt_get_result($prepdeldelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_add WHERE psaid = ?;";
			$prepdeladdstrikedel = mysqli_prepare($db, $querydeladdstrikedel);
			mysqli_stmt_bind_param ($prepdeladdstrikedel, 'i', $pastrikeid);
			mysqli_stmt_execute($prepdeladdstrikedel);
			$resultdeladdstrikedel = mysqli_stmt_get_result($prepdeladdstrikedel);

			$querydeladdstrike = "DELETE FROM pending_strikes_add WHERE id = ?;";
			$prepdeladdstrike = mysqli_prepare($db, $querydeladdstrike);
			mysqli_stmt_bind_param ($prepdeladdstrike, 'i', $pastrikeid);
			mysqli_stmt_execute($prepdeladdstrike);
			$resultdeladdstrike = mysqli_stmt_get_result($prepdeladdstrike);
		}		

		if ( $pdstrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_strikes_del WHERE psdid = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 'i', $pdstrikeid);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);

			$querydeldelcode = "DELETE vdsd FROM validate_del_strikes_del vdsd INNER JOIN pending_del_strikes_del pdsd ON pdsd.id = vdsd.pdsdid WHERE pdsd.psdid = ?;";
			$prepdeldelcode = mysqli_prepare($db, $querydeldelcode);
			mysqli_stmt_bind_param ($prepdeldelcode, 'i', $pdstrikeid);
			mysqli_stmt_execute($prepdeldelcode);
			$resultdeldelcode = mysqli_stmt_get_result($prepdeldelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_del WHERE psdid = ?;";
			$prepdeladdstrikedel = mysqli_prepare($db, $querydeladdstrikedel);
			mysqli_stmt_bind_param ($prepdeladdstrikedel, 'i', $pdstrikeid);
			mysqli_stmt_execute($prepdeladdstrikedel);
			$resultdeladdstrikedel = mysqli_stmt_get_result($prepdeladdstrikedel);

			$querydeladdstrike = "DELETE FROM pending_strikes_del WHERE id = ?;";
			$prepdeladdstrike = mysqli_prepare($db, $querydeladdstrike);
			mysqli_stmt_bind_param ($prepdeladdstrike, 'i', $pdstrikeid);
			mysqli_stmt_execute($prepdeladdstrike);
			$resultdeladdstrike = mysqli_stmt_get_result($prepdeladdstrike);
		}		

		if ( $pdastrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_del_strikes_add WHERE pdsaid = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 'i', $pdastrikeid);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_add WHERE id = ?;";
			$prepdeladdstrikedel = mysqli_prepare($db, $querydeladdstrikedel);
			mysqli_stmt_bind_param ($prepdeladdstrikedel, 'i', $pdastrikeid);
			mysqli_stmt_execute($prepdeladdstrikedel);
			$resultdeladdstrikedel = mysqli_stmt_get_result($prepdeladdstrikedel);
		}		
		
		if ( $pddstrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_del_strikes_del WHERE pdsdid = ?;";
			$prepdelcode = mysqli_prepare($db, $querydelcode);
			mysqli_stmt_bind_param ($prepdelcode, 'i', $pddstrikeid);
			mysqli_stmt_execute($prepdelcode);
			$resultdelcode = mysqli_stmt_get_result($prepdelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_del WHERE id = ?;";
			$prepdeladdstrikedel = mysqli_prepare($db, $querydeladdstrikedel);
			mysqli_stmt_bind_param ($prepdeladdstrikedel, 'i', $pddstrikeid);
			mysqli_stmt_execute($prepdeladdstrikedel);
			$resultdeladdstrikedel = mysqli_stmt_get_result($prepdeladdstrikedel);
		}		
	}

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
