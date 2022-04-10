<?php
define('index_origin', true);
include '../db.inc.php';
$querygetbeers = "SELECT beers.name as beername, beers.id as beerid FROM beers WHERE breweryid ='" . $_POST['breweryid'] . "' ORDER BY beername ASC";
$resultgetbeers = mysqli_query($db, $querygetbeers);
?>
<select name="beer" id="beer">
	<option value="blank">Select brewery first</option>
  	<?php
		while($row = mysqli_fetch_array($resultgetbeers))
		{
			echo "<option value='" . $row['beerid'] . "'>" . $row['beername'] . "</option>";
		}
	?>
</select>
