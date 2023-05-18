<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
$queryuser = "SELECT name FROM user WHERE veteran = 0;";
$resultuser = mysqli_query($db, $queryuser);
?>
<center>
<table border="0" cellspacing="30">
<tr>
<td>
                <center><h2>Add Strike</h2>
                <form action="/add_strikes.php" method="post">
			<input type="text" name="reason" placeholder="Reason" required><br>
			<input type="checkbox" id="event" name="event" value="1">
			<label for="event">Event?</label>
			<br><br>
                        <?php
                                while($row = mysqli_fetch_array($resultuser))
                                {
                                        echo "<input type='submit' name='user' value='" . htmlspecialchars($row['name']) . "'>";
                                        echo " ";
                                }
                        ?>
                </form></center>
</td>
<?php if (isset($mobile)) { echo "</tr><tr>";} ?>
<td>
                <center><h2>Del Strike</h2>
                <form action="/del_strikes.php" method="post">
			<input type="text" name="reason" placeholder="Reason" required><br>
			<input type="checkbox" id="event" name="event" value="1">
			<label for="event">Event?</label>
                        <br><br>
                         <?php
                                $resultuser = mysqli_query($db, $queryuser);
                                while($row = mysqli_fetch_array($resultuser))
                                {
                                        echo "<input type='submit' name='user' value='" . htmlspecialchars($row['name']) . "'>";
                                        echo " ";
                                }
                        ?>
                </form></center>
</td>
</tr>
</table>
</center>
