<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
        include 'db.inc.php';
?>
<html>
<br><br>
<center>
<table border='1' <?php if(isset($mobile)){ echo "style='font-size:10px'"; }?>>
	<tr>
		<th colspan="3"><h2>Veterans<h2></th>
	</tr>
	<tr>
		<td valign="top">
			<?php include 'veterans_list.php'; ?>
		</td>
		<td>
			<?php
				if (check_login($sessionid)[0] && check_login($sessionid)[1] == '1')
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
					<input type="text" id="name" name="name" placeholder="Name" required ';
					if (isset($mobile)){echo 'style="font-size: 10px" size="10"';}
					echo '><br><br>
					<input type="password" id="password" name="password" placeholder="Passwort" required ';
					if (isset($mobile)){echo 'style="font-size: 10px" size="10"';}
					echo '><br><br>
        				<input type="submit" name="veterans-login" value="Login" />
					</form>';
				}
			?>
		</td>
		<td valign="top">
			<?php
				$queryvisits = 'SELECT visits.id, name, date, notice FROM veterans INNER JOIN visits ON veterans.id = visits.veteranid;';
				$resultvisits = mysqli_query($db, $queryvisits);
				echo "<center><table border='1'";
				if(isset($mobile)){ echo "style='font-size:10px'";}
				echo ">
				<tr>
				<th>Date</th>
				<th>Name</th>
				<th>Notice</th>
				<th>Remove</th>
				</tr>";

				while($row = mysqli_fetch_array($resultvisits))
				{
					echo "<tr>";
					echo "<td>" . htmlspecialchars($row['date']) . "</td>";
					echo "<td>" . htmlspecialchars($row['name']) . "</td>";
					echo "<td>" . htmlspecialchars($row['notice']) . "</td>";
					if (check_login($sessionid)[0] && check_login($sessionid)[1] == '1')
					{
						echo "<td> <form action='/delete_visit.php' method='post'> <input type='submit' name='id' value='Delete'> <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'> </form> </td>";
					}
					echo "</tr>";
				}
				echo '</table>';
			?>
		</td>
	</tr>
</table>
</center>
</html>
