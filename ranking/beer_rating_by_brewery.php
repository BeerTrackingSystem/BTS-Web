<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>

<?php
	#$queryallratingswithavg = "SELECT beers.brewery, beers.name AS beername, beers.style, user.name AS username, ranking_beers.rating, avg(ranking_beers.rating) OVER(PARTITION BY ranking_beers.beerid) AS total_average FROM beers INNER JOIN ranking_beers ON beers.id = ranking_beers.beerid INNER JOIN user ON ranking_beers.userid = user.id ORDER BY brewery ASC, beername ASC;";
	#$resultallratingswithavg = mysqli_query($db, $queryallratingswithavg);

	$queryallbreweries = "SELECT name AS brewery FROM breweries;";
	$resultallbreweries = mysqli_query($db, $queryallbreweries);
	echo "<table id='ratingsbybrewery' border='0'>";
	while($row = mysqli_fetch_array($resultallbreweries))
	{
		echo "<tr>";
		$brewery = $row['brewery'];

		$querybeers = "SELECT beers.name AS beername from beers INNER JOIN breweries ON beers.breweryid = breweries.id WHERE breweries.name = ?;";
		$prepbeers = mysqli_prepare($db, $querybeers);
		mysqli_stmt_bind_param ($prepbeers, 's', $brewery);
		mysqli_stmt_execute($prepbeers);
		$resultbeers = mysqli_stmt_get_result($prepbeers);

		$firsttable = true;

		while ($row = mysqli_fetch_array($resultbeers))
                {
			echo "<td colspan='4'>";
			if ($firsttable == true)
			{
				echo "<br>";
				echo "<h3 style='display:inline;'>" . htmlspecialchars($brewery) . "</h3>";
				echo "</td></tr><tr><td style='vertical-align:top'>";
			}
			else
			{
			}
			$beername = $row['beername'];


		$queryratings = "SELECT beers.style, user.name AS username, ranking_beers.rating FROM beers INNER JOIN ranking_beers ON beers.id = ranking_beers.beerid INNER JOIN user ON ranking_beers.userid = user.id INNER JOIN breweries ON beers.breweryid = breweries.id WHERE breweries.name = ? AND beers.name = ? ORDER BY username ASC;";
		$prepratings = mysqli_prepare($db, $queryratings);
		mysqli_stmt_bind_param ($prepratings, 'ss', $brewery, $beername);
		mysqli_stmt_execute($prepratings);
		$resultratings = mysqli_stmt_get_result($prepratings);

		echo "<table border='1'>
		<thead>
		<tr>
		<th>Beer Name</th>
		<th>Style</th>
		<th>User</th>
		<th>Rating</th>
		</tr>
		</thead>
		";

		while($row = mysqli_fetch_array($resultratings))
		{
			echo "<tr>";
			echo "<td>" . htmlspecialchars($beername) . "</td>";
			echo "<td>" . htmlspecialchars($row['style']) . "</td>";
			echo "<td>" . htmlspecialchars($row['username']) . "</td>";
			echo "<td><center>" . htmlspecialchars($row['rating']) . "</center></td>";
			echo "</tr>";
		}

		$queryaverage = "SELECT avg(ranking_beers.rating) AS average FROM ranking_beers INNER JOIN beers ON ranking_beers.beerid = beers.id INNER JOIN breweries ON beers.breweryid = breweries.id WHERE breweries.name = ? AND beers.name = ?;";
		$prepaverage = mysqli_prepare($db, $queryaverage);
		mysqli_stmt_bind_param ($prepaverage, 'ss', $brewery, $beername);
		mysqli_stmt_execute($prepaverage);
		$resultaverage = mysqli_stmt_get_result($prepaverage);

		echo "<tfoot>";
		echo "<tr>";
		echo "<td colspan='3'>Overall Rating</td>";
		while ($row = mysqli_fetch_array($resultaverage))
		{
			echo "<td>" . htmlspecialchars($row['average']) .  "</td>";
		}
		echo "</tr>
		</tfoot>
		</table>";
		echo "</td>";
		$firsttable = false;
                }
		echo "</tr>";
	}
	echo "</table>";
?>
