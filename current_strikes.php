<?php
$query = "SELECT name, currentstrikes FROM user INNER JOIN current_strikes ON user.id = current_strikes.userid WHERE user.veteran = 0;";

$result = mysqli_query($db, $query);

echo "<center><table border='1'>
<tr>
<th>Name</th>
<th>Strikes</th>
</tr></center>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['name'] . "</td>";
echo "<td align='center'>" . $row['currentstrikes'] . "</td>";
echo "</tr>";
}
echo "</table>";
?>
