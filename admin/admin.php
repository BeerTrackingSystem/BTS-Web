<?php
        include '../db.inc.php';
?>

<?php
        $querymisc = "SELECT title, heading FROM misc WHERE id LIKE '2';";
        $resultmisc = mysqli_query($db, $querymisc);

        while ($row = $resultmisc->fetch_assoc()) {
                $title = $row['title'];
                $heading = $row['heading'];
        }
?>

<html>
<head>
	<title><?php echo $title; ?></title>
</head>

<body>
<center><h1><?php echo $heading; ?></h1></center>

<center><table border=1>
	<tr>
		<td valign="top">
			<form action="./create_user.php" method="post">
				Create User:
				<br><br>
				<table>
				<tr>
					<td>Name:</td>
					<td><input type='text' name='name' style='width: 70px;' required></td>
				</tr>
	
				<tr>		
					<td>EMail:</td>
					<td><input type='text' name='email' style='width: 250px;' required></td>
				</tr>
		
				<tr>		
					<td>Password:</td>
					<td><input type='text' name='password' style='width: 250px;' required></td>
				</tr>

				<tr>
				</tr>

				<tr>
					<td colspan='2'><input type='submit' value='Create'></td>
				</tr>
				</table>
			</form>
		</td>
	
		<td valign="top">
			<form action="./add_quote.php" method="post">
				Add quote:
				<br><br>
				<table>
				<tr>
					<td>Quote:</td>
					<td><input type='text' name='quote' style='width: 250px;' required></td>
				</tr>

				<tr>
				</tr>

				<tr>
					<td colspan='2'><input type='submit' value='Create'></td>
				</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td valign="top">
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
		</td>
		
		<td valign="top">
			<form action="./move_user2veteran.php" method="post">
				Move User to Veteran:
				<br><br>
				<table>
				<tr>
					<td>Name:</td>
					<td><input type='text' name='name' style='width: 70px;' required></td>
				</tr>

				<tr>		
					<td>Neue EMail:</td>
					<td><input type='text' name='email' style='width: 250px;'></td>
				</tr>
	
				<tr>		
					<td>Password</td>
					<td><input type='text' name='password' style='width: 250px;'required></td>
				</tr>

				<tr>
					<td colspan='2'><input type='submit' value='Move'></td>
				</tr>
				</table>

			</form>
		</td>
	</tr>
	
	<tr>
		<td valign="top">
			<form action="./change_misc.php" method="post">
				Change misc things:
				<br><br>
			        <table>
			        <tr>
                      			<td>Title:</td>
		                        <td><input type='text' name='title' style='width: 250px;'></td>
        		        </tr>

		                <tr>
               			        <td>Heading:</td>
		                        <td><input type='text' name='heading' style='width: 250px;'></td>
               			 </tr>

			        <tr>
                      			<td>Admin Title:</td>
		                        <td><input type='text' name='admintitle' style='width: 250px;'></td>
        		        </tr>

		                <tr>
               			        <td>Admin Heading:</td>
		                        <td><input type='text' name='adminheading' style='width: 250px;'></td>
               			 </tr>
		                <tr>
                		        <td colspan='2'><input type='submit' value='Change'></td>
		                </tr>
			        </table>
			</form>
		</td>
	</tr>
</table></center>
</body>
</html>
