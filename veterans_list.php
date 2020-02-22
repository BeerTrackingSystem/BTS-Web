<?php
$query = "SELECT name FROM veterans;";

$result = mysqli_query($db, $query);

echo "<center><table border='1'>
<tr>
<th>You're always welcome!</th>
</tr></center>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['name'] . "</td>";
echo "</tr>";
}
echo "</table>";
?>
