<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
$query = "SELECT amount FROM current_stock WHERE id = '1';";
$result = mysqli_query($db, $query);

$result_count = mysqli_num_rows($result);

if ($result_count == '1')
{
	echo "<center><table border='1'>
	<tr>
	<th>Amount(0,33/0,5)</th>
	</tr></center>";

	while($row = mysqli_fetch_array($result))
	{
		echo "<tr>";
		echo "<td align='center'>" . $row['amount'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
else
{
	$queryaddstock = "INSERT INTO current_stock (id) VALUE ('1');";
	$resultaddstock = mysqli_query($db, $queryaddstock);
	header("Location: http://$_SERVER[HTTP_HOST]");
}
?>
