<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>

<?php
	$queryallratings = "SELECT breweries.name AS brewery, beers.name AS beername, beers.style, avg(ranking_beers.rating) AS rating FROM ranking_beers INNER JOIN beers ON beers.id = ranking_beers.beerid INNER JOIN breweries ON beers.breweryid = breweries.id GROUP BY ranking_beers.beerid ORDER BY rating DESC;";
	$resultallratings = mysqli_query($db, $queryallratings);
	echo "<table id='ratingsbybeer' border='0'>";
		echo "<tr><td><br><h3 style='display:inline;'>Overall ratings</h3></td></tr>";
		echo "<tr><td>";
		echo "<table border='1'>";
		echo "<thead>
		<tr>
		<th>Brewery</th>
		<th>Beer Name</th>
		<th>Style</th>
		<th>Rating</th>
		</tr>
		</thead>
		";
		
		while($row = mysqli_fetch_array($resultallratings))
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($row['brewery']) . "</td>";
			echo "<td>" . htmlspecialchars($row['beername']) . "</td>";
			echo "<td>" . htmlspecialchars($row['style']) . "</td>";
			echo "<td><center>" . htmlspecialchars($row['rating']) . "</center></td>";
			echo "</tr>";
		}

		#$queryaverage = "SELECT AVG(ranking_beers.rating) AS average FROM ranking_beers;";
		#Alternative, fancy sql query - avg of avg - little difference between query above
		$queryaverage = "SELECT AVG(ratingsgrouped) AS average FROM (SELECT AVG(ranking_beers.rating) AS ratingsgrouped FROM ranking_beers GROUP BY ranking_beers.beerid) Temp;";
		$resultaverage = mysqli_query($db, $queryaverage);

		echo "<tfoot>";
		echo "<tr>";
		echo "<td colspan='3'>Overall Rating</td>";
		while ($row = mysqli_fetch_array($resultaverage))
		{
			echo "<td>" . htmlspecialchars($row['average']) .  "</td>";
		}
		echo "</tr>";
		echo "</tfoot>";
		echo "</td></tr>";
		echo "</table>";
	echo "</table>";
?>
