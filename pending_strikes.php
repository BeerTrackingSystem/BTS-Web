<?php
$querypendingstrikesadd = "SELECT pending_strikes_add.id, name, date, uservalidate1, uservalidate2, uservalidate3 FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid WHERE pending_strikes_add.validated = '0';";
$querypendingstrikesdel = "SELECT pending_strikes_del.id, name, date, uservalidate1, uservalidate2, uservalidate3 FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid WHERE pending_strikes_del.validated = '0';";

$resultpendingstrikesadd = mysqli_query($db, $querypendingstrikesadd);
$resultpendingstrikesdel = mysqli_query($db, $querypendingstrikesdel);

echo "<center><h2>Pending Add</h2></center>";

echo "<center><table border='1'>
<tr>
<th>Name</th>
<th>Datum</th>
<th>Validierung 1</th>
<th>Validierung 2</th>
<th>Validierung 3</th>
<th>Remove</th>
</tr></center>";

while($row = mysqli_fetch_array($resultpendingstrikesadd))
{
echo "<tr>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['uservalidate1'] . "</td>";
echo "<td>" . $row['uservalidate2'] . "</td>";
echo "<td>" . $row['uservalidate3'] . "</td>";
echo "<td> <form action='/del_add_strikes.php' method='post'> <input type='submit' name='id' value='Delete'> <input type='hidden' name='id' value='" . $row['id'] . "'> </form> </td>";
echo "</tr>";
}
echo "</table>";


echo "<center><h2>Pending Del</h2></center>";

echo "<center><table border='1'>
<tr>
<th>Name</th>
<th>Datum</th>
<th>Validierung 1</th>
<th>Validierung 2</th>
<th>Validierung 3</th>
<th>Remove</th>
</tr></center>";

while($row = mysqli_fetch_array($resultpendingstrikesdel))
{
echo "<tr>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['uservalidate1'] . "</td>";
echo "<td>" . $row['uservalidate2'] . "</td>";
echo "<td>" . $row['uservalidate3'] . "</td>";
echo "<td> <form action='/del_del_strikes.php' method='post'> <input type='submit' name='id' value='Delete'> <input type='hidden' name='id' value='" . $row['id'] . "'> </form> </td>";
echo "</tr>";
}
echo "</table>";
?>
