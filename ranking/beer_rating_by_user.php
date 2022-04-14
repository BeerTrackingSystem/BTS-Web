<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>

<?php
	$queryalluser = "SELECT id AS userid, name AS username FROM user;";
	$resultalluser = mysqli_query($db, $queryalluser);
	echo "<table id='ratingsbyuser' border='0'>";
	while($row = mysqli_fetch_array($resultalluser))
	{
		echo "<tr>";
		$username = $row['username'];
		$userid = $row['userid'];

		echo "<td colspan='4'>";
		echo "<br>";
		echo "<h3 style='display:inline;'>" . $username . "</h3>";
		echo "</td></tr><tr><td style='vertical-align:top'>";
		$beername = $row['beername'];

		$queryratings = "SELECT breweries.name AS brewery, beers.name AS beername, beers.style, ranking_beers.rating FROM ranking_beers INNER JOIN beers ON beers.id = ranking_beers.beerid INNER JOIN breweries ON beers.breweryid = breweries.id WHERE ranking_beers.userid = ? ORDER BY brewery ASC, beername ASC;";
		$prepratings = mysqli_prepare($db, $queryratings);
		mysqli_stmt_bind_param ($prepratings, 'i', $userid);
		mysqli_stmt_execute($prepratings);
		$resultratings = mysqli_stmt_get_result($prepratings);

		echo "<table border='1'>
		<thead>
		<tr>
		<th>Brewery</th>
		<th>Beer Name</th>
		<th>Style</th>
		<th>Rating</th>
		</tr>
		</thead>
		";

		while($row = mysqli_fetch_array($resultratings))
		{
			echo "<tr>";
			echo "<td>" . $row['brewery'] . "</td>";
			echo "<td>" . $row['beername'] . "</td>";
			echo "<td>" . $row['style'] . "</td>";
			echo "<td><center>" . $row['rating'] . "</center></td>";
			echo "</tr>";
		}

		$queryaverage = "SELECT avg(ranking_beers.rating) AS average FROM ranking_beers WHERE ranking_beers.userid = ?;";
		$prepaverage = mysqli_prepare($db, $queryaverage);
		mysqli_stmt_bind_param ($prepaverage, 'i', $userid);
		mysqli_stmt_execute($prepaverage);
		$resultaverage = mysqli_stmt_get_result($prepaverage);

		echo "<tfoot>";
		echo "<tr>";
		echo "<td colspan='3'>Overall Rating</td>";
		while ($row = mysqli_fetch_array($resultaverage))
		{
			echo "<td>" . $row['average'] .  "</td>";
		}
		echo "</tr>
		</tfoot>
		</table>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
?>
