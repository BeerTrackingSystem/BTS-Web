<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
$querypendingstrikesadd = "SELECT pending_strikes_add.id, name, date, validations_needed, validations_acc, reason FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid WHERE pending_strikes_add.validated = '0' AND pending_strikes_add.deleted = '0';";
$querypendingstrikesdel = "SELECT pending_strikes_del.id, name, date, validations_needed, validations_acc, reason FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid WHERE pending_strikes_del.validated = '0' AND pending_strikes_del.deleted = '0';";

$resultpendingstrikesadd = mysqli_query($db, $querypendingstrikesadd);
$resultpendingstrikesdel = mysqli_query($db, $querypendingstrikesdel);

echo "<center><h2>Pending Add</h2></center>";

echo "<center><table border='1' "; 
if(isset($mobile)) 
{ 
	echo "style='font-size:10px;'";
}
echo ">
<tr>
<th>Name</th>
<th>Datum</th>
<th>Validierungen benötigt</th>
<th>Validierungen durchgeführt</th>
<th>Reason</th>
<th>Remove</th>
</tr></font>";

while($row = mysqli_fetch_array($resultpendingstrikesadd))
{
echo "<tr>";
echo "<td>" . htmlspecialchars($row['name']) . "</td>";
echo "<td>" . htmlspecialchars($row['date']) . "</td>";
echo "<td>" . htmlspecialchars($row['validations_needed']) . "</td>";
echo "<td>" . htmlspecialchars($row['validations_acc']) . "</td>";
echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
if (check_login($sessionid)[0] && check_login($sessionid)[1] == '0')
{
	echo "<td> <form action='/del_add_strikes.php' method='post'> <input type='submit' name='id' value='Delete'> <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'> </form> </td>";
}
echo "</tr>";
}
echo "</table></center>";


echo "<center><h2>Pending Del</h2></center>";

echo "<center><table border='1' ";
	if(isset($mobile))
{
        echo "style='font-size:10px;'";
}
echo ">
<tr>
<th>Name</th>
<th>Datum</th>
<th>Validierungen benötigt</th>
<th>Validierungen durchgeführt</th>
<th>Reason</th>
<th>Remove</th>
</tr>";

while($row = mysqli_fetch_array($resultpendingstrikesdel))
{
echo "<tr>";
echo "<td>" . htmlspecialchars($row['name']) . "</td>";
echo "<td>" . htmlspecialchars($row['date']) . "</td>";
echo "<td>" . htmlspecialchars($row['validations_needed']) . "</td>";
echo "<td>" . htmlspecialchars($row['validations_acc']) . "</td>";
echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
if (check_login($sessionid)[0] && check_login($sessionid)[1] == '0')
{
	echo "<td> <form action='/del_del_strikes.php' method='post'> <input type='submit' name='id' value='Delete'> <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'> </form> </td>";
}
echo "</tr>";
}
echo "</table></center>";
?>
