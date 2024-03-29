<?php
	define('index_origin', true);
	session_start();
        include '../db.inc.php';
?>

<?php
	$querymisc = "SELECT attribute,value FROM misc WHERE object = 'admin_page' AND (attribute = 'title' OR attribute = 'heading');";
        $resultmisc = mysqli_query($db, $querymisc);

        while ($row = $resultmisc->fetch_assoc()) {
                if ($row['attribute'] == 'title')
                {
                        $title = $row['value'];
                }
                if ($row['attribute'] == 'heading')
                {
                        $heading = $row['value'];
                }
        }
?>

<html>
<head>
	<title><?php echo htmlspecialchars($title); ?></title>
</head>

<body>
<center><h1><?php echo htmlspecialchars($heading); ?></h1></center>

<center><table border=1>
	<tr>
		<td valign="top">
			<form action="./add_user.php" method="post">
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
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['date']) . ' - ' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['reason']) . "</option>" ;
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
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['date']) . ' - ' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['reason']) . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				</tr>
				<br><br>
                                <tr>
                                        <td colspan='2'>
                                                <input type='number' name='newneededvalidations' min='0' style='width: 50px;' required>
                                                <input type='submit' value='Change'>
					</td>
                                </tr>
                                 </table>
                        </form>
                </td>

		<td valign="top">
			<form action="./add_key.php" method="post">
                                Add Key:
                                <br><br>
                                <table>
                                <tr>
                                        <td>Description:</td>
                                        <td><input type='text' name='description' style='width: 250px;' required></td>
                                </tr>
                                <tr>
                                        <td>Key:</td>
					<td>
						<input type='text' id='generatedKey' name='generatedKey' style='width: 250px;' required readonly>
						<input type='button' id='generateKey' name='generateKey' value='Generate'>
					</td>
                                </tr>

                                <tr>
                                </tr>

                                <tr>
                                        <td colspan='2'><input type='submit' value='Create'></td>
                                </tr>
                                </table>
                        </form>
			<form action="./delete_key.php" method="post">
				Delete Key:
			        <table>
		                <tr>
					<select name='keyid'>
					<option value="blank" selected>Select the key</option>
						<?php
							$querygetkeys = "SELECT id, description FROM api_keys;";
							$resultgetkeys = mysqli_query($db, $querygetkeys);
	
							while($row = mysqli_fetch_array($resultgetkeys))
							{
								echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['description']) . "</option>" ;
							}
						?>
					</select>
                        		<input type='submit' value='Delete'>
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
					<option value="blank" selected>Select your option</option>
						<?php
							$querygetquotes = "SELECT id, quote FROM quotes;";
							$resultgetquotes = mysqli_query($db, $querygetquotes);
	
							while($row = mysqli_fetch_array($resultgetquotes))
							{
								echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['quote']) . "</option>" ;
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
		
		<td valign="top" colspan='2'>
			<form action="./resend_codes.php" method="post">
                                Resend Codes:
                                <table border='0'>
                                <tr style="outline: thin solid">
				<td>
                                        Code:
				</td>
				<td>
                                        <select name='addcodes'>
                                                <option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetaddcodes = "SELECT validate_strikes_add.id, code, pending_strikes_add.reason, user.name FROM validate_strikes_add INNER JOIN user ON validate_strikes_add.userid = user.id INNER JOIN pending_strikes_add ON validate_strikes_add.psaid = pending_strikes_add.id;";
                                                        $resultgetaddcodes = mysqli_query($db, $querygetaddcodes);

                                                        while($row = mysqli_fetch_array($resultgetaddcodes))
                                                        {
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>for " .  htmlspecialchars($row['name']) . ': ' . htmlspecialchars($row['code']) . ' = ' . htmlspecialchars($row['reason']) . "</option>" ;
							}
						?>
					</select>
					<br>
					<select name='delcodes'>
						<option value="blank" selected>Select your option</option>
						<?php
                                                        $querygetdelcodes = "SELECT validate_strikes_del.id, code, pending_strikes_del.reason, user.name FROM validate_strikes_del INNER JOIN user ON validate_strikes_del.userid = user.id INNER JOIN pending_strikes_del ON validate_strikes_del.psdid = pending_strikes_del.id;";
                                                        $resultgetdelcodes = mysqli_query($db, $querygetdelcodes);

                                                        while($row = mysqli_fetch_array($resultgetdelcodes))
                                                        {
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>for " .  htmlspecialchars($row['name']) . ': ' . htmlspecialchars($row['code']) . ' = ' . htmlspecialchars($row['reason']) . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				</td>
                                </tr>
                                <tr style="outline: thin solid">
				<td>
                                        Delete Codes:
				</td>
				<td>
                                        <select name='deladdcodes'>
                                                <option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetdeladdcodes = "SELECT validate_del_strikes_add.id, code, pending_strikes_add.reason, user.name FROM validate_del_strikes_add INNER JOIN user ON validate_del_strikes_add.userid = user.id INNER JOIN pending_del_strikes_add ON validate_del_strikes_add.pdsaid = pending_del_strikes_add.id INNER JOIN pending_strikes_add ON pending_strikes_add.id = pending_del_strikes_add.psaid;";
                                                        $resultgetdeladdcodes = mysqli_query($db, $querygetdeladdcodes);

                                                        while($row = mysqli_fetch_array($resultgetdeladdcodes))
                                                        {
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>for " .  htmlspecialchars($row['name']) . ': ' . htmlspecialchars($row['code']) . ' = ' . htmlspecialchars($row['reason']) . "</option>" ;
                                                        }
						?>
                                        </select>
					<br>
                                        <select name='deldelcodes'>
						<option value="blank" selected>Select your option</option>
						<?php
                                                        $querygetdeldelcodes = "SELECT validate_del_strikes_del.id, code, pending_strikes_del.reason, user.name FROM validate_del_strikes_del INNER JOIN user ON validate_del_strikes_del.userid = user.id INNER JOIN pending_del_strikes_del ON validate_del_strikes_del.pdsdid = pending_del_strikes_del.id INNER JOIN pending_strikes_del ON pending_strikes_del.id = pending_del_strikes_del.psdid;";
                                                        $resultgetdeldelcodes = mysqli_query($db, $querygetdeldelcodes);

                                                        while($row = mysqli_fetch_array($resultgetdeldelcodes))
                                                        {
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>for " .  htmlspecialchars($row['name']) . ': ' . htmlspecialchars($row['code']) . ' = ' . htmlspecialchars($row['reason']) . "</option>" ;
                                                        }
                                                ?>
                                        </select>
				</td>
                                </tr>
                                </table>
                                <br>
                                                <input type='submit' value='Resend'>
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
						<option value="blank" selected>Select your option</option>
                                                <?php
                                                        $querygetquotes = "SELECT id, quote FROM quotes;";
                                                        $resultgetquotes = mysqli_query($db, $querygetquotes);

                                                        while($row = mysqli_fetch_array($resultgetquotes))
                                                        {
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['quote']) . "</option>" ;
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
					Object:
					<select name='miscobject' id='miscobject'>
                                                <option value="blank" selected>Select object</option>
                                                <?php
                                                        $querygetobjects = "SELECT object FROM misc GROUP BY object;";
                                                        $resultgetobjects = mysqli_query($db, $querygetobjects);

                                                        while($row = mysqli_fetch_array($resultgetobjects))
                                                        {
                                                                echo "<option value='" . htmlspecialchars($row['object']) . "'>" . htmlspecialchars($row['object']) . "</option>";
                                                        }
                                                ?>
                                        </select>
					<br>
					Attribute:
					<select name='miscattribute' id='miscattribute'>
                                                <option value="blank" selected>Select attribute first</option>
                                        </select>
					<br>
					<label for="currentvalue">Current Value:</label>
					<input type="text" id="currentvalue" name="currentvalue" value="" readonly disabled>
					<br>
					<label for="newvalue">New Value:</label>
					<input type='text' name='newvalue' id="newvalue" style='width: 250px;' required>
		                </tr>
                                <tr>
                                        <td><input type='submit' value='Change'></td>
                                </tr>
			        </table>
			</form>
<script src="../packages/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $('#miscobject').on('change',function(){
      getmiscattributes();
      getmiscvalues();
    });

    $('#miscattribute').on('change',function(){
      getmiscvalues();
    });

    $('#generateKey').on('click',function(){
      generateString();
    });

    function getmiscattributes(){
      var miscobject = $('#miscobject').val();

      $.ajax({
          type:'POST',
          url:'getmiscattributes.php',
          data:'miscobject='+miscobject,
          success:function(data){
            $('#miscattribute').html(data);
          }
      });
      };

    function getmiscvalues(){
      var miscobject = $('#miscobject').val();
      var miscattribute = $('#miscattribute').val();

      $.ajax({
          type:'POST',
          url:'getmiscvalues.php',
	  data: { miscobject : miscobject, miscattribute : miscattribute },
          success:function(data){
            $('#currentvalue').val(data);
          }
      });
      };

    function generateString(){
      $.ajax({
          url:'generatestring.php',
          success:function(data){
            $('#generatedKey').val(data);
          }
      });
      };
  });
</script>
		</td>
		
		<td valign="top" colspan='2'>
                        <form action="./modify_user.php" method="post">
                                Modify user/veteran data:
                                <br><br>
                                <table>
                                <tr>
                                        <td>Name:</td>
                                        <td><input type='text' name='name' style='width: 250px;'></td>
                                </tr>

                                <tr>
                                        <td>Email:</td>
                                        <td><input type='text' name='email' style='width: 250px;'></td>
                                 </tr>

                                <tr>
                                        <td>SMS:</td>
                                        <td><input type='text' name='sms' style='width: 250px;'></td>
                                </tr>

                                <tr>
                                        <td>Password:</td>
                                        <td><input type='text' name='password' style='width: 250px;'></td>
                                 </tr>
                                <tr>
                                        <td>Last Pay:</td>
					<td><input type="date" name="lastpay"></td>
                                 </tr>
                                <tr>
					<td colspan='2'>
						<select name='id'>
							<option value="blank" selected>Select your option</option>
                                                	<?php
                                                        	$querygetuser = "SELECT id, name FROM user WHERE veteran = '0';";
	                                                        $resultgetuser = mysqli_query($db, $querygetuser);

        	                                                while($row = mysqli_fetch_array($resultgetuser))
                	                                        {
									#0=user
                        	                                        echo "<option value='0-" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['name']) . "</option>" ;
                                	                        }
								
								$querygetveteran = "SELECT id, name FROM veterans;";
                                                                $resultgetveteran = mysqli_query($db, $querygetveteran);

                                                                while($row = mysqli_fetch_array($resultgetveteran))
                                                                {
									#1=veteran
                                                                        echo "<option value='1-" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['name']) . " (Veteran)</option>" ;
                                                                }
                                        	        ?>
                                        	</select>
						<input type='submit' value='Modify'>
					</td>
                                </tr>
                                </table>
                        </form>
                </td>
	</tr>

	 <tr>
                 <td valign="top" colspan='2'>
                        <form action="./delete_val_pstrikes.php" method="post">
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
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['date']) . ' - ' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['reason']) . "</option>" ;
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
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['date']) . ' - ' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['reason']) . "</option>" ;
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
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['date']) . ' - ' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['reason']) . "</option>" ;
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
                                                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" .  htmlspecialchars($row['date']) . ' - ' . htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['reason']) . "</option>" ;
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
		<td valign="top" colspan='2'>
                	Modify brewery/beer data:
				<br><br>
                                <table>
                                <tr style='outline: thin solid'>
					<form action="./add_brewery.php" method="post">
                                        	<td><input type='text' name='newbrewery' placeholder='Brewery Name' style='width: 250px;' required></td>
                                        	<td><input type='submit' value='Add Brewery' name='addbrewery'></td>
                        		</form>	
                                </tr>
                                <tr style='outline: thin solid'>
					<form action="./add_beer.php" method="post">
                                        <td>
						<select name='breweryid'>
                                        		<option value="blank" selected>Select brewery</option>
                                                	<?php
                                                        	$querygetbreweries = "SELECT breweries.id as breweryid, breweries.name as brewery FROM breweries ORDER BY brewery ASC;";
                                                        	$resultgetbreweries = mysqli_query($db, $querygetbreweries);

                                                        	while($row = mysqli_fetch_array($resultgetbreweries))
                                                        	{
                                                                	echo "<option value='" . htmlspecialchars($row['breweryid']) . "'>" . htmlspecialchars($row['brewery']) . "</option>";
                                                        	}
                                                	?>
                                        	</select></td>
						<td><input type='text' name='newbeer' placeholder='Beer Name' style='width: 250px;' required></td>
						<td><input type='text' name='style' placeholder='Style' style='width: 150px;' required></td>
                                        	<td><input type='submit' value='Add Beer' name='addbeer'></td>
                        		</form>	
                                 </tr>

                                <tr style='outline: thin solid'>
					<form action="./change_brewery.php" method="post">
                                        <td>
                                        	<select name='breweryid'>
                                               		<option value="blank" selected>Select brewery</option>
                                                	<?php
                                                        	$querygetbreweries = "SELECT breweries.id as breweryid, breweries.name as brewery FROM breweries ORDER BY brewery ASC;";
                                                        	$resultgetbreweries = mysqli_query($db, $querygetbreweries);

                                                        	while($row = mysqli_fetch_array($resultgetbreweries))
                                                        	{
                                                                	echo "<option value='" . htmlspecialchars($row['breweryid']) . "'>" . htmlspecialchars($row['brewery']) . "</option>";
                                                        	}
                                                	?>
                                        	</select></td>
                                        	<td><input type='text' name='newbreweryname' placeholder='New Brewery Name' style='width: 250px;' required></td>
                                        	<td><input type='submit' value='Modify Brewery' name='changebrewery'></td>
                        		</form>	
                                </tr>

                                <tr style='outline: thin solid'>
					<form action="./change_beer.php" method="post">
                                        <td>
                                        	<select name='beerid'>
                                                	<option value="blank" selected>Select beer</option>
                                                	<?php
                                                        	$querygetbeers = "SELECT beers.id as beerid, beers.name as beer, breweries.name AS brewery FROM beers INNER JOIN breweries ON beers.breweryid = breweries.id ORDER BY brewery ASC, beer ASC;";
                                                        	$resultgetbeers = mysqli_query($db, $querygetbeers);

                                                        	while($row = mysqli_fetch_array($resultgetbeers))
                                                        	{
                                                                	echo "<option value='" . htmlspecialchars($row['beerid']) . "'>" . htmlspecialchars($row['brewery']) . " - " . htmlspecialchars($row['beer']) . "</option>";
                                                        	}
                                                	?>
                                        	</select></td>
                                        	<td><input type='text' name='newbeername' placeholder='New Beer Name' style='width: 250px;'></td>
                                        	<td><input type='text' name='newbeerstyle' placeholder='New Beer Style' style='width: 250px;'></td>
                                        	<td><input type='submit' value='Modify Beer' name='changebeer'></td>
                        		</form>	
                                 </tr>

                                <tr style='outline: thin solid'>
					<form action="./delete_brewery.php" method="post">
					<td>
                                        	<select name='breweryid'>
                                                	<option value="blank" selected>Select brewery</option>
                                                	<?php
                                                        	$querygetbreweries = "SELECT breweries.id as breweryid, breweries.name as brewery FROM breweries ORDER BY brewery ASC;";
                                                        	$resultgetbreweries = mysqli_query($db, $querygetbreweries);

                                                        	while($row = mysqli_fetch_array($resultgetbreweries))
                                                        	{
                                                                	echo "<option value='" . htmlspecialchars($row['breweryid']) . "'>" . htmlspecialchars($row['brewery']) . "</option>";
                                                        	}
                                                	?>
                                        	</select></td>
                                        	<td><input type='submit' value='Delete Brewery' name='deletebrewery'></td>
                        		</form>	
                                </tr>

				<tr style='outline: thin solid'>
					<form action="./delete_beer.php" method="post">
                                        <td>
                                        	<select name='beerid'>
                                                	<option value="blank" selected>Select beer</option>
                                                	<?php
								$querygetbeers = "SELECT beers.id as beerid, beers.name as beer, breweries.name AS brewery FROM beers INNER JOIN breweries ON beers.breweryid = breweries.id ORDER BY brewery ASC, beer ASC;";
                                                        	$resultgetbeers = mysqli_query($db, $querygetbeers);

                                                        	while($row = mysqli_fetch_array($resultgetbeers))
                                                        	{
                                                                	echo "<option value='" . htmlspecialchars($row['beerid']) . "'>" . htmlspecialchars($row['brewery']) . " - " . htmlspecialchars($row['beer']) . "</option>";
                                                        	}
                                                	?>
                                        	</select></td>
                                        	<td><input type='submit' value='Delete Beer' name='deletebeer'></td>
                        		</form>	
				</tr>
                                </table>
		</td>
	</tr>
</table></center>
</body>
</html>
