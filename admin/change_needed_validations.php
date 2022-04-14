<?php
if (!isset($_POST['newneededvalidations']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	session_start();
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
$pastrikeid = $_POST['pastrikes'];
$pdstrikeid = $_POST['pdstrikes'];

$newneededvalidations = $_POST['newneededvalidations'];

if (($pastrikeid != 'blank' && $pdstrikeid != 'blank') || ($pastrikeid == 'blank' && $pdstrikeid == 'blank'))
{
	echo '<script>alert("Only select one pending strike at once!");</script>';
        echo '<script>location.replace(\'http://' . $_SERVER[HTTP_HOST] . '/admin\')</script>';
}
else
{
	if ($pastrikeid != 'blank')
	{
		$querycurrentvalacc = "SELECT validations_acc FROM pending_strikes_add WHERE id = ?;";
		$prepcurrentvalacc = mysqli_prepare($db, $querycurrentvalacc);
		mysqli_stmt_bind_param ($prepcurrentvalacc, 'i', $pastrikeid);
		mysqli_stmt_execute($prepcurrentvalacc);
		$resultcurrentvalacc = mysqli_stmt_get_result($prepcurrentvalacc);
		while ($row = $resultcurrentvalacc->fetch_assoc()) 
		{
                	$currentvalacc = $row['validations_acc'];
			$minneededvalidations = $currentvalacc + 1;
		}

		$querycurrentusers = "SELECT id FROM user WHERE veteran = '0';";
                $resultcurrentusers = mysqli_query($db, $querycurrentusers);
		$user_count = mysqli_num_rows($resultcurrentusers);
                $maxneededvalidations = $user_count;


		if ($newneededvalidations >= $minneededvalidations && $newneededvalidations <= $maxneededvalidations)
		{
			$querycurrentvalneeded = "SELECT validations_needed FROM pending_strikes_add WHERE id = ?;";
			$prepcurrentvalneeded = mysqli_prepare($db, $querycurrentvalneeded);
			mysqli_stmt_bind_param ($prepcurrentvalneeded, 'i', $pastrikeid);
			mysqli_stmt_execute($prepcurrentvalneeded);
			$resultcurrentvalneeded = mysqli_stmt_get_result($prepcurrentvalneeded);
			while ($row = $resultcurrentvalneeded->fetch_assoc()) 
			{
                		$currentvalneeded = $row['validations_needed'];
			}

			if ($newneededvalidations > $currentvalneeded)
			{
				$querycodesavail = "SELECT id FROM validate_strikes_add WHERE psaid = ?;";
				$prepcodesavail = mysqli_prepare($db, $querycodesavail);
				mysqli_stmt_bind_param ($prepcodesavail, 'i', $pastrikeid);
				mysqli_stmt_execute($prepcodesavail);
				$resultcodesavail = mysqli_stmt_get_result($prepcodesavail);

				$current_code_count = mysqli_num_rows($resultcodesavail);
				$neededcodes = $newneededvalidations - $currentvalacc;

				if ($current_code_count >= $neededcodes)
				{
					$queryupdatevalneeded = "UPDATE pending_strikes_add SET validations_needed = ? WHERE id = ?;";
					$prepupdatevalneeded = mysqli_prepare($db, $queryupdatevalneeded);
					mysqli_stmt_bind_param ($prepupdatevalneeded, 'ii', $newneededvalidations, $pastrikeid);
					mysqli_stmt_execute($prepupdatevalneeded);
					$resultupdatevalneeded = mysqli_stmt_get_result($prepupdatevalneeded);

        	                        header("Location: https://$_SERVER[HTTP_HOST]/admin");
				}
				else
				{
					$newneededcodes = $neededcodes - $current_code_count;

					$queryuser = "SELECT name FROM user WHERE veteran = '0';";
					$resultuser = mysqli_query($db, $queryuser);
					$usercount = '0';

					echo '<form action="./generate_codes.php" method="post">';
					while($row = mysqli_fetch_array($resultuser))
                                	{
						$usercount = $usercount + 1;
                                        	echo "<input type='checkbox' name='user$usercount' value='" . $row['name'] . "'>";
						echo "<label for='user$usercount'>" . $row['name'] . "</label><br>";
	                                }

					echo '<script src="../packages/jquery.min.js"></script>
						<script id="rendered-js">
						$("input:checkbox").click(function () {
						var bol = $("input:checkbox:checked").length >= ' . $newneededcodes . ';
						$("input:checkbox").not(":checked").attr("disabled", bol);
						});
						</script>';
					echo '<button type="submit" name="submit" value="pastrike">Generate new Codes</button>';
					$_SESSION['pastrikeid'] = $pastrikeid;
					$_SESSION['usercount'] = $usercount;
					$_SESSION['newneededvalidations'] = $newneededvalidations;
					echo '</form>';
				}
			}
			else
			{
				$queryupdatevalneeded = "UPDATE pending_strikes_add SET validations_needed = ? WHERE id = ?;";
				$prepupdatevalneeded = mysqli_prepare($db, $queryupdatevalneeded);
				mysqli_stmt_bind_param ($prepupdatevalneeded, 'ii', $newneededvalidations, $pastrikeid);
				mysqli_stmt_execute($prepupdatevalneeded);
				$resultupdatevalneeded = mysqli_stmt_get_result($prepupdatevalneeded);

				header("Location: https://$_SERVER[HTTP_HOST]/admin");
			}
		}
		else
		{
			echo '<script>alert("The value must be ' . $minneededvalidations . ' <= X <= ' . $maxneededvalidations . '");</script>';
			echo '<script>location.replace(\'http://' . $_SERVER[HTTP_HOST] . '/admin\')</script>';
		}
	}
	elseif ($pdstrikeid != 'blank')
	{
                $querycurrentvalacc = "SELECT validations_acc FROM pending_strikes_del WHERE id = ?;";
		$prepcurrentvalacc = mysqli_prepare($db, $querycurrentvalacc);
		mysqli_stmt_bind_param ($prepcurrentvalacc, 'i', $pdstrikeid);
		mysqli_stmt_execute($prepcurrentvalacc);
		$resultcurrentvalacc = mysqli_stmt_get_result($prepcurrentvalacc);
                while ($row = $resultcurrentvalacc->fetch_assoc())
                {
                        $currentvalacc = $row['validations_acc'];
                        $minneededvalidations = $currentvalacc + 1;
                }

                $querycurrentusers = "SELECT id FROM user WHERE veteran = '0';";
                $resultcurrentusers = mysqli_query($db, $querycurrentusers);
                $user_count = mysqli_num_rows($resultcurrentusers);
                $maxneededvalidations = $user_count;


                if ($newneededvalidations >= $minneededvalidations && $newneededvalidations <= $maxneededvalidations)
                {
                        $querycurrentvalneeded = "SELECT validations_needed FROM pending_strikes_del WHERE id = ?;";
			$prepcurrentvalneeded = mysqli_prepare($db, $querycurrentvalneeded);
			mysqli_stmt_bind_param ($prepcurrentvalneeded, 'i', $pdstrikeid);
			mysqli_stmt_execute($prepcurrentvalneeded);
			$resultcurrentvalneeded = mysqli_stmt_get_result($prepcurrentvalneeded);
                        while ($row = $resultcurrentvalneeded->fetch_assoc())
                        {
                                $currentvalneeded = $row['validations_needed'];
                        }

                        if ($newneededvalidations > $currentvalneeded)
                        {
                                $querycodesavail = "SELECT id FROM validate_strikes_del WHERE psdid = ?;";
				$prepcodesavail = mysqli_prepare($db, $querycodesavail);
				mysqli_stmt_bind_param ($prepcodesavail, 'i', $pdstrikeid);
				mysqli_stmt_execute($prepcodesavail);
				$resultcodesavail = mysqli_stmt_get_result($prepcodesavail);

                                $current_code_count = mysqli_num_rows($resultcodesavail);
                                $neededcodes = $newneededvalidations - $currentvalacc;

                                if ($current_code_count >= $neededcodes)
                                {
                                        $queryupdatevalneeded = "UPDATE pending_strikes_del SET validations_needed = ? WHERE id = ?;";
					$prepupdatevalneeded = mysqli_prepare($db, $queryupdatevalneeded);
					mysqli_stmt_bind_param ($prepupdatevalneeded, 'ii', $newneededvalidations, $pdstrikeid);
					mysqli_stmt_execute($prepupdatevalneeded);
					$resultupdatevalneeded = mysqli_stmt_get_result($prepupdatevalneeded);

                                        header("Location: https://$_SERVER[HTTP_HOST]/admin");
                                }
                                else
                                {
                                        $newneededcodes = $neededcodes - $current_code_count;

                                        $queryuser = "SELECT name FROM user WHERE veteran = '0';";
                                        $resultuser = mysqli_query($db, $queryuser);
                                        $usercount = '0';

                                        echo '<form action="./generate_codes.php" method="post">';
                                        while($row = mysqli_fetch_array($resultuser))
                                        {
                                                $usercount = $usercount + 1;
                                                echo "<input type='checkbox' name='user$usercount' value='" . $row['name'] . "'>";
                                                echo "<label for='user$usercount'>" . $row['name'] . "</label><br>";
                                        }

                                        echo '<script src="../packages/jquery.min.js"></script>
                                                <script id="rendered-js">
                                                $("input:checkbox").click(function () {
                                                var bol = $("input:checkbox:checked").length >= ' . $newneededcodes . ';
                                                $("input:checkbox").not(":checked").attr("disabled", bol);
                                                });
                                                </script>';
                                        echo '<button type="submit" name="submit" value="pdstrike">Generate new Codes</button>';
                                        $_SESSION['pdstrikeid'] = $pdstrikeid;
                                        $_SESSION['usercount'] = $usercount;
                                        $_SESSION['newneededvalidations'] = $newneededvalidations;
                                        echo '</form>';
                                }
                        }
                        else
                        {
                                $queryupdatevalneeded = "UPDATE pending_strikes_del SET validations_needed = ? WHERE id = ?;";
				$prepupdatevalneeded = mysqli_prepare($db, $queryupdatevalneeded);
				mysqli_stmt_bind_param ($prepupdatevalneeded, 'ii', $newneededvalidations, $pdstrikeid);
				mysqli_stmt_execute($prepupdatevalneeded);
				$resultupdatevalneeded = mysqli_stmt_get_result($prepupdatevalneeded);

                                header("Location: https://$_SERVER[HTTP_HOST]/admin");
                        }
                }
                else
                {
                        echo '<script>alert("The value must be ' . $minneededvalidations . ' <= X <= ' . $maxneededvalidations . '");</script>';
                        echo '<script>location.replace(\'http://' . $_SERVER[HTTP_HOST] . '/admin\')</script>';
                }
	}
}
?>
