<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
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
echo "<td>" . $row['brewery'] . "</td>";
echo "<td>" . $row['beername'] . "</td>";
echo "<td align='center'>" . $row['average'] . "</td>";
echo "</tr>";
}
echo "</table>";
?>
