<?php
	define('index_origin', true);
	session_start();
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
		
		 <td valign="top">
                        <form action="./change_needed_validations.php" method="post">
                                Change needed validations:
                                <br><br>
                                <table>
                                <tr>
					Adds:
					<select name='pastrikes'>
                                                <option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetpastrikes = "SELECT pending_strikes_add.id, name, date, reason FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid WHERE pending_strikes_add.validated = '0' AND pending_strikes_add.deleted = '0';";
                                                        $resultgetpastrikes = mysqli_query($db, $querygetpastrikes);

                                                        while($row = mysqli_fetch_array($resultgetpastrikes))
                                                        {
                                                                echo "<option value='" . $row['id'] . "'>" .  $row['date'] . ' - ' . $row['name'] . ' - ' . $row['reason'] . "</option>" ;
                                                        }
                                                ?>
                                        </select>
                                </tr>
				<br><br>
				<tr>
					Dels:
					<select name='pdstrikes'>
                                                <option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetpdstrikes = "SELECT pending_strikes_del.id, name, date, reason FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid WHERE pending_strikes_del.validated = '0' AND pending_strikes_del.deleted = '0';";
                                                        $resultgetpdstrikes = mysqli_query($db, $querygetpdstrikes);

                                                        while($row = mysqli_fetch_array($resultgetpdstrikes))
                                                        {
                                                                echo "<option value='" . $row['id'] . "'>" .  $row['date'] . ' - ' . $row['name'] . ' - ' . $row['reason'] . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				</tr>
				<br><br>
                                <tr>
                                        <td colspan='2'>
                                                <input type='number' name='newneededvalidations' style='width: 50px;' required>
                                                <input type='submit' value='Change'>
					</td>
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
                        <form action="./delete_quote.php" method="post">
                                Delete quote:
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
                                        <td colspan='2'><input type='submit' value='Delete'></td>
                                </tr>
                                 </table>
                        </form>
                </td>

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

	 <tr>
                 <td valign="top" colspan='2'>
                        <form action="./del-val_pstrikes.php" method="post">
                                <center>Delete or validate pending strikes:</center>
                                <br>
				<center>
                                <table border='1' style="width: 100%">
                                <tr>
				<td>
					Pending Add Strikes
					<br>
                                        <select name='pastrikes'>
						<option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetpastrikes = "SELECT pending_strikes_add.id, name, date, reason FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid WHERE pending_strikes_add.validated = '0' AND pending_strikes_add.deleted = '0';";
                                                        $resultgetpastrikes = mysqli_query($db, $querygetpastrikes);

                                                        while($row = mysqli_fetch_array($resultgetpastrikes))
                                                        {
                                                                echo "<option value='" . $row['id'] . "'>" .  $row['date'] . ' - ' . $row['name'] . ' - ' . $row['reason'] . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				<br><br>
					Pending Del Strikes
					<br>
                                        <select name='pdstrikes'>
						<option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetpdstrikes = "SELECT pending_strikes_del.id, name, date, reason FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid WHERE pending_strikes_del.validated = '0' AND pending_strikes_del.deleted = '0';";
                                                        $resultgetpdstrikes = mysqli_query($db, $querygetpdstrikes);

                                                        while($row = mysqli_fetch_array($resultgetpdstrikes))
                                                        {
                                                                echo "<option value='" . $row['id'] . "'>" .  $row['date'] . ' - ' . $row['name'] . ' - ' . $row['reason'] . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				</td>
				<td>
					Pending Del of Add Strikes
					<br>
                                        <select name='pdastrikes'>
						<option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetpdastrikes = "SELECT pending_del_strikes_add.id, name, pending_strikes_add.date, pending_strikes_add.reason FROM user INNER JOIN pending_strikes_add ON user.id = pending_strikes_add.userid INNER JOIN pending_del_strikes_add ON pending_strikes_add.id = pending_del_strikes_add.psaid WHERE pending_del_strikes_add.validated = '0' AND pending_strikes_add.validated = '0';";
                                                        $resultgetpdastrikes = mysqli_query($db, $querygetpdastrikes);

                                                        while($row = mysqli_fetch_array($resultgetpdastrikes))
                                                        {
                                                                echo "<option value='" . $row['id'] . "'>" .  $row['date'] . ' - ' . $row['name'] . ' - ' . $row['reason'] . "</option>" ;
                                                        }
                                                ?>
                                        </select>
					<br><br>
					Pending Del of Del Strikes
					<br>
                                        <select name='pddstrikes'>
						<option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetpddstrikes = "SELECT pending_del_strikes_del.id, name, pending_strikes_del.date, pending_strikes_del.reason FROM user INNER JOIN pending_strikes_del ON user.id = pending_strikes_del.userid INNER JOIN pending_del_strikes_del ON pending_strikes_del.id = pending_del_strikes_del.psdid WHERE pending_del_strikes_del.validated = '0' AND pending_strikes_del.validated = '0';";
                                                        $resultgetpddstrikes = mysqli_query($db, $querygetpddstrikes);

                                                        while($row = mysqli_fetch_array($resultgetpddstrikes))
                                                        {
                                                                echo "<option value='" . $row['id'] . "'>" .  $row['date'] . ' - ' . $row['name'] . ' - ' . $row['reason'] . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				</td>
                                </tr>
                                 </table>
					<br>
                                        <input type='submit' name='submit' value='Delete'>
                                        <input type='submit' name='submit' value='Validate'></center>
                        </form>
		</td>
	</tr>
</table></center>
</body>
</html>
