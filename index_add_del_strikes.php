<?php
$queryuser = "SELECT name FROM user;";
$resultuser = mysqli_query($db, $queryuser);
?>
<br>
                <center><h2>Add Strike</h2></center>
                <form action="/add_strikes.php" method="post">
                        <?php
                                while($row = mysqli_fetch_array($resultuser))
                                {
                                        echo "<input type='submit' name='user' value='" . $row['name'] . "'>";
                                        echo " ";
                                }
                        ?>
                </form>

<br>
                <center><h2>Del Strike</h2></center>
                <form action="/del_strikes.php" method="post">
                         <?php
                                $resultuser = mysqli_query($db, $queryuser);
                                while($row = mysqli_fetch_array($resultuser))
                                {
                                        echo "<input type='submit' name='user' value='" . $row['name'] . "'>";
                                        echo " ";
                                }
                        ?>
                </form>

<br>

