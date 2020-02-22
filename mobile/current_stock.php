<?php
$query = "SELECT amount FROM current_stock;";

$result = mysqli_query($db, $query);

echo "<center><table border='1'>
<tr>
<th>Amount(0,33/0,5)</th>
</tr></center>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td align='center'>" . $row['amount'] . "</td>";
echo "</tr>";
}
echo "</table>";
?>
