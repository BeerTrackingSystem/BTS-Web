<?php
$queryuser = "SELECT name FROM user WHERE veteran = 0;";
$resultuser = mysqli_query($db, $queryuser);
?>
<br>
<center>
<table border="0" cellspacing="30">
<tr>
<td>
                <center><h2>Add Strike</h2>
                <form action="/add_strikes.php" method="post">
			<input type="text" name="reason" placeholder="Reason" required>
			<br><br>
                        <?php
                                while($row = mysqli_fetch_array($resultuser))
                                {
                                        echo "<input type='submit' name='user' value='" . $row['name'] . "'>";
                                        echo " ";
                                }
                        ?>
                </form></center>
</td>
<td>
                <center><h2>Del Strike</h2>
                <form action="/del_strikes.php" method="post">
			<input type="text" name="reason" placeholder="Reason" required>
                        <br><br>
                         <?php
                                $resultuser = mysqli_query($db, $queryuser);
                                while($row = mysqli_fetch_array($resultuser))
                                {
                                        echo "<input type='submit' name='user' value='" . $row['name'] . "'>";
                                        echo " ";
                                }
                        ?>
                </form></center>
</td>
</tr>
</table>
</center>
