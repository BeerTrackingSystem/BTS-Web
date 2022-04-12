<?php
define('index_origin', true);
include '../db.inc.php';
$querygetattributes = "SELECT attribute FROM misc WHERE object ='" . $_POST['miscobject'] . "' ORDER BY attribute ASC";
$resultgetattributes = mysqli_query($db, $querygetattributes);
?>
<select name="miscattribute" id="miscattribute">
	<option value="blank">Select object first</option>
  	<?php
		while($row = mysqli_fetch_array($resultgetattributes))
		{
			echo "<option value='" . $row['attribute'] . "'>" . $row['attribute'] . "</option>";
		}
	?>
</select>
