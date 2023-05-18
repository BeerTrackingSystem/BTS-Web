<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
$query = "SELECT name FROM veterans;";

$result = mysqli_query($db, $query);

echo "<center><table border='1' ";
if(isset($mobile))
{
        echo "style='font-size:10px;'";
}
echo ">
<tr>
<th>You're always welcome!</th>
</tr></center>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . htmlspecialchars($row['name']) . "</td>";
echo "</tr>";
}
echo "</table>";
?>
