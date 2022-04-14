<?php
define('index_origin', true);
include '../db.inc.php';
$querygetattributes = "SELECT attribute FROM misc WHERE object = ? ORDER BY attribute ASC";
$prepgetattributes = mysqli_prepare($db, $querygetattributes);
mysqli_stmt_bind_param ($prepgetattributes, 's', $_POST['miscobject']);
mysqli_stmt_execute($prepgetattributes);
$resultgetattributes = mysqli_stmt_get_result($prepgetattributes);
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
