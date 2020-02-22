<?php
$queryuser = "SELECT name FROM user;";
$resultuser = mysqli_query($db, $queryuser);
?>
<br>
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

<br>
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

<br>
