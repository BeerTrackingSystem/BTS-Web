<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
$query = "SELECT breweries.name AS brewery, beers.name AS beername, AVG(ranking_beers.rating) AS average FROM ranking_beers INNER JOIN beers ON ranking_beers.beerid = beers.id INNER JOIN breweries ON beers.breweryid = breweries.id GROUP BY ranking_beers.beerid ORDER BY average DESC, brewery ASC, beername ASC LIMIT 3;";

$result = mysqli_query($db, $query);

echo "<center><table border='1'>
<tr>
<th>Brewery</th>
<th>Beer Name</th>
<th>Rating</th>
</tr></center>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . htmlspecialchars($row['brewery']) . "</td>";
echo "<td>" . htmlspecialchars($row['beername']) . "</td>";
echo "<td align='center'>" . htmlspecialchars($row['average']) . "</td>";
echo "</tr>";
}
echo "</table>";
?>
