<?php
define('index_origin', true);
include '../db.inc.php';
$querygetbeers = "SELECT beers.name as beername, beers.id as beerid FROM beers WHERE breweryid = ? ORDER BY beername ASC";
$prepgetbeers = mysqli_prepare($db, $querygetbeers);
mysqli_stmt_bind_param ($prepgetbeers, 'i', $_POST['breweryid']);
mysqli_stmt_execute($prepgetbeers);
$resultgetbeers = mysqli_stmt_get_result($prepgetbeers);
?>
<select name="beer" id="beer">
	<option value="blank">Select brewery first</option>
  	<?php
		while($row = mysqli_fetch_array($resultgetbeers))
		{
			echo "<option value='" . htmlspecialchars($row['beerid']) . "'>" . htmlspecialchars($row['beername']) . "</option>";
		}
	?>
</select>
