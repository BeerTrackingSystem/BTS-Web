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
                                $queryaddstrike = "UPDATE current_strikes INNER JOIN pending_strikes_add ON current_strikes.userid = pending_strikes_add.userid SET currentstrikes = currentstrikes+1 WHERE pending_strikes_add.id LIKE '$pastrikeid';";
                                $resultaddstrike = mysqli_query($db, $queryaddstrike);

                                $queryvalidatepsa ="UPDATE pending_strikes_add SET validated = '1' WHERE id LIKE '$pastrikeid';";
                                $resultvalidatepsa = mysqli_query($db, $queryvalidatepsa);
                                #Message when third/final validation of the pending strike is done
				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Der Strike wurde erfolgreich validiert!') </script>";

                                $querydelcode = "DELETE FROM validate_strikes_add WHERE psaid LIKE '$pastrikeid';";
				$resultdelcode = mysqli_query($db, $querydelcode);

                                $querydeladdcodedel = "DELETE vdsa FROM validate_del_strikes_add vdsa INNER JOIN pending_del_strikes_add pdsa ON pdsa.id = vdsa.pdsaid WHERE pdsa.psaid LIKE '$pastrikeid';";
				$resultdeladdcodedel = mysqli_query($db, $querydeladdcodedel);

                                $querydeladdstrikedel = "DELETE FROM pending_del_strikes_add WHERE psaid LIKE '$pastrikeid';";
				$resultdeladdstrikedel = mysqli_query($db, $querydeladdstrikedel);
		}

		if ( $pdstrikeid != 'blank')
		{
                                $querycurrentstrikes = "Select currentstrikes FROM current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid WHERE pending_strikes_del.id LIKE '$pdstrikeid';";
                                $resultcurrentstrikes = mysqli_query($db, $querycurrentstrikes);
                                while ($row = $resultcurrentstrikes->fetch_assoc()) {
                                        $currentstrikes = $row['currentstrikes'];
                                }

                                if ($currentstrikes >= "5"){
                                        $querydelstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid SET currentstrikes = currentstrikes-5 WHERE pending_strikes_del.id LIKE '$pdstrikeid';";
                                        $resultdelstrike = mysqli_query($db, $querydelstrike);
                                }
                                else {
                                        $querydelremainingstrike = "UPDATE current_strikes INNER JOIN pending_strikes_del ON current_strikes.userid = pending_strikes_del.userid SET currentstrikes = '0' WHERE pending_strikes_del.id LIKE '$pdstrikeid';";
                                        $resultdelremainingstrike = mysqli_query($db, $querydelremainingstrike);
                                }

                                $queryvalidatepsd ="UPDATE pending_strikes_del SET validated = '1' WHERE id LIKE '$pdstrikeid';";
                                $resultvalidatepsd = mysqli_query($db, $queryvalidatepsd);
                                #Message when third/final validation of the pending strike is done
				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Die Strike-Löschung wurde erfolgreich validiert!') </script>";

                                $querydelcode = "DELETE FROM validate_strikes_del WHERE psdid LIKE '$pdstrikeid';";
				$resultdelcode = mysqli_query($db, $querydelcode);

				$querydeldelcodedel = "DELETE vdsd FROM validate_del_strikes_del vdsd INNER JOIN pending_del_strikes_del pdsd ON pdsd.id = vdsd.pdsdid WHERE pdsd.psdid LIKE '$pdstrikeid';";
                                $resultdeldelcodedel = mysqli_query($db, $querydeldelcodedel);

                                $querydeldelstrikedel = "DELETE FROM pending_del_strikes_del WHERE psdid LIKE '$pdstrikeid';";
                                $resultdeldelstrikedel = mysqli_query($db, $querydeldelstrikedel);
		}

		if ( $pdastrikeid != 'blank')
		{
                                $querydelvalstrikedel = "DELETE vsa FROM validate_strikes_add vsa INNER JOIN pending_del_strikes_add pdsa ON vsa.psaid = pdsa.psaid WHERE pdsa.id LIKE '$pdastrikeid';";
                                $resultdelvalstrikedel = mysqli_query($db, $querydelvalstrikedel);

                                $querydelcode = "DELETE FROM validate_del_strikes_add WHERE pdsaid LIKE '$pdastrikeid';";
                                $resultdelcode = mysqli_query($db, $querydelcode);

                                $querydelpendingdelstrikedel = "UPDATE pending_del_strikes_add SET validated = '1' WHERE id LIKE '$pdastrikeid';";
                                $resultdelpendingdelstrikedel = mysqli_query($db, $querydelpendingdelstrikedel);

                                $querydelpendingstrike = "UPDATE pending_strikes_add psa INNER JOIN pending_del_strikes_add pdsa ON psa.id = pdsa.psaid SET deleted = '1' WHERE pdsa.id LIKE '$pdastrikeid';";
                                $resultdelpendingstrike = mysqli_query($db, $querydelpendingstrike);

				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Der Strike-Add wurde erfolgreich abgebrochen!') </script>";
		}

		if ( $pddstrikeid != 'blank')
		{
				$querydelvalstrikedel = "DELETE vsd FROM validate_strikes_del vsd INNER JOIN pending_del_strikes_del pdsd ON vsd.psdid = pdsd.psdid WHERE pdsd.id LIKE '$pddstrikeid';";
                                $resultdelvalstrikedel = mysqli_query($db, $querydelvalstrikedel);

                                $querydelcode = "DELETE FROM validate_del_strikes_del WHERE pdsdid LIKE '$pddstrikeid';";
                                $resultdelcode = mysqli_query($db, $querydelcode);

                                $querydelpendingdelstrikedel = "UPDATE pending_del_strikes_del SET validated = '1' WHERE id LIKE '$pddstrikeid';";
                                $resultdelpendingdelstrikedel = mysqli_query($db, $querydelpendingdelstrikedel);

                                $querydelpendingstrike = "UPDATE pending_strikes_del psd INNER JOIN pending_del_strikes_del pdsd ON psd.id = pdsd.psdid SET deleted = '1' WHERE pdsd.id LIKE '$pddstrikeid';";
                                $resultdelpendingstrike = mysqli_query($db, $querydelpendingstrike);

				echo "<script>alert('Validation wurde erfolgreich manuell durchgeführt! Der Strike-Del wurde erfolgreich abgebrochen!') </script>";
		}
	} elseif ($workflow == 'Delete')
	{
		if ( $pastrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_strikes_add WHERE psaid LIKE '$pastrikeid';";
                        $resultdelcode = mysqli_query($db, $querydelcode);

			$querydeldelcode = "DELETE vdsa FROM validate_del_strikes_add vdsa INNER JOIN pending_del_strikes_add pdsa ON pdsa.id = vdsa.pdsaid WHERE pdsa.psaid LIKE '$pastrikeid';";
                        $resultdeldelcode = mysqli_query($db, $querydeldelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_add WHERE psaid LIKE '$pastrikeid';";
                        $resultdeladdstrikedel = mysqli_query($db, $querydeladdstrikedel);

			$querydeladdstrike = "DELETE FROM pending_strikes_add WHERE id LIKE '$pastrikeid';";
                        $resultdeladdstrike = mysqli_query($db, $querydeladdstrike);
		}		

		if ( $pdstrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_strikes_del WHERE psdid LIKE '$pdstrikeid';";
                        $resultdelcode = mysqli_query($db, $querydelcode);

			$querydeldelcode = "DELETE vdsd FROM validate_del_strikes_del vdsd INNER JOIN pending_del_strikes_del pdsd ON pdsd.id = vdsd.pdsdid WHERE pdsd.psdid LIKE '$pdstrikeid';";
                        $resultdeldelcode = mysqli_query($db, $querydeldelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_del WHERE psdid LIKE '$pdstrikeid';";
                        $resultdeladdstrikedel = mysqli_query($db, $querydeladdstrikedel);

			$querydeladdstrike = "DELETE FROM pending_strikes_del WHERE id LIKE '$pdstrikeid';";
                        $resultdeladdstrike = mysqli_query($db, $querydeladdstrike);
		}		

		if ( $pdastrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_del_strikes_add WHERE pdsaid LIKE '$pdastrikeid';";
                        $resultdelcode = mysqli_query($db, $querydelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_add WHERE id LIKE '$pdastrikeid';";
                        $resultdeladdstrikedel = mysqli_query($db, $querydeladdstrikedel);
		}		
		
		if ( $pddstrikeid != 'blank')
		{
			$querydelcode = "DELETE FROM validate_del_strikes_del WHERE pdsdid LIKE '$pddstrikeid';";
                        $resultdelcode = mysqli_query($db, $querydelcode);

			$querydeladdstrikedel = "DELETE FROM pending_del_strikes_del WHERE id LIKE '$pddstrikeid';";
                        $resultdeladdstrikedel = mysqli_query($db, $querydeladdstrikedel);
		}		
	}

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
