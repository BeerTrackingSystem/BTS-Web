<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
$query = "SELECT name, currentstrikes, last_pay FROM user INNER JOIN current_strikes ON user.id = current_strikes.userid WHERE user.veteran = 0;";

$result = mysqli_query($db, $query);

echo "<center><table border='1'>
<tr>
<th>Name</th>
<th>Strikes</th>
<th>Last Pay</th>
</tr></center>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . htmlspecialchars($row['name']) . "</td>";
echo "<td align='center'>" . htmlspecialchars($row['currentstrikes']) . "</td>";
echo "<td align='center'>" . htmlspecialchars($row['last_pay']) . "</td>";
echo "</tr>";
}
echo "</table>";
?>
