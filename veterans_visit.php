<?php
        include 'db.inc.php';
?>
<html>
<br><br>
<center>
<table border=1>
	<tr>
		<th colspan="3"><h2>Veterans<h2></th>
	</tr>
	<tr>
		<td valign="top">
			<?php include 'veterans_list.php'; ?>
		</td>
		<td>
			<?php
				if (isset($_COOKIE['veteran']) && strpos($_COOKIE['veteran'], 'yes') !== false)	
				{
					echo '<form action=".\schedule_visit.php" method="post">
  					<input type="date" name="visitdate" required>
					<br>
					<input type="text" name="visitnotice" size="30" placeholder="Notice">
					<br>
  					<input type="submit" name="schedulevisit" value="Schedule next visit">
					</form>';
    				}
				else
				{
					echo '<form action=".\validateveteranlogin.php" method="post">
        				<input type="text" id="name" name="name" placeholder="Name" required><br><br>
        				<input type="password" id="password" name="password" placeholder="Passwort" required><br><br>
        				<input type="submit" name="veterans-login" value="Login" />
					</form>';
				}
			?>
		</td>
		<td valign="top">
			<?php
				$queryvisits = 'SELECT visits.id, name, date, notice FROM veterans INNER JOIN visits ON veterans.id = visits.veteranid;';
				$resultvisits = mysqli_query($db, $queryvisits);
				echo "<center><table border='1'>
				<tr>
				<th>Date</th>
				<th>Name</th>
				<th>Notice</th>
				<th>Remove</th>
				</tr>";

				while($row = mysqli_fetch_array($resultvisits))
				{
					echo "<tr>";
					echo "<td>" . $row['date'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['notice'] . "</td>";
					echo "<td> <form action='/delete_visit.php' method='post'> <input type='submit' name='id' value='Delete'> <input type='hidden' name='id' value='" . $row['id'] . "'> </form> </td>";
					echo "</tr>";
				}
				echo '</table>';
			?>
		</td>
	</tr>
</table>
</center>
</html>
