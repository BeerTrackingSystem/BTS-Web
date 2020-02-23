<?php
        include '../db.inc.php';
?>

<html>
<head>
	<title>Admin Panel</title>
</head>

<body>
<form action="./create_user.php" method="post">
Create User:
<br><br>
	<table>
		<tr>
			<td>Name:</td>
			<td><input type='text' name='name' style='width: 70px;'></td>
		</tr>

		<tr>		
			<td>EMail:</td>
			<td><input type='text' name='email' style='width: 250px;'></td>
		</tr>
	
		<tr>
		</tr>
		<tr>
			<td colspan='2'><input type='submit' value='Create'></td>
		</tr>
	</table>

</form>

<br><br>

<form action="./add_quote.php" method="post">
Add quote:
<br><br>
	<table>
		<tr>
			<td>Quote:</td>
			<td><input type='text' name='quote' style='width: 250px;'></td>
		</tr>

		<tr>
		</tr>

		<tr>
			<td colspan='2'><input type='submit' value='Create'></td>
		</tr>
	</table>
</form>

<br><br>

<form action="./change_quote.php" method="post">
Change quote:
<br><br>
        <table>
                <tr>
			<select name='quoteid'>
				<?php
					$querygetquotes = "SELECT id, quote FROM quotes;";
					$resultgetquotes = mysqli_query($db, $querygetquotes);

					while($row = mysqli_fetch_array($resultgetquotes))
					{
						echo "<option value='" . $row['id'] . "'>" .  $row['quote'] . "</option>" ;
					}
				?>
			</select>
                </tr>

                <tr>
                        <td colspan='2'><input type='submit' value='Change'></td>
                </tr>
        </table>
</form>

<br><br>
<form action="./move_user2veteran.php" method="post">
Move User to Veteran:
<br><br>
	<table>
		<tr>
			<td>Name:</td>
			<td><input type='text' name='name' style='width: 70px;'></td>
		</tr>

		<tr>		
			<td>Neue EMail:</td>
			<td><input type='text' name='email' style='width: 250px;'></td>
		</tr>
	
		<tr>		
			<td>Password</td>
			<td><input type='text' name='password' style='width: 250px;'></td>
		</tr>

		<tr>
			<td colspan='2'><input type='submit' value='Move'></td>
		</tr>
	</table>

</form>
</body>
</html>
