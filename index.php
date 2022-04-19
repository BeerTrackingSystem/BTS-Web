<?php
	define('index_origin', true);
	session_start();
	$sessionid=$_COOKIE['PHPSESSID'];
	include 'db.inc.php';
	include 'check_login.php';
?>

<?php
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                {
			$mobile = "1";
                }
?>

<?php
	$querymisc = "SELECT attribute,value FROM misc WHERE object = 'main_page' AND (attribute = 'title' OR attribute = 'heading');";
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

	$querymiscmobile = "SELECT attribute,value FROM misc WHERE object = 'mobile_main_page' AND (attribute = 'title' OR attribute = 'heading');";
	$resultmiscmobile = mysqli_query($db, $querymiscmobile);

	while ($row = $resultmiscmobile->fetch_assoc()) {
		if ($row['attribute'] == 'title')
		{
               		$titlemobile = $row['value'];
		}
		if ($row['attribute'] == 'heading')
		{
			$headingmobile = $row['value'];
		}
        }
?>

<html>
	<head>
		<?php
			if (!isset($mobile))
			{
				echo "<title>" . htmlspecialchars($title) . "</title>";
			}
			else
			{
				echo "<title>" . htmlspecialchars($titlemobile) . "</title>";
			}
		?>
		<link rel="Favicon" href="favicon.ico" type="image/x-icon"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<style>
			#version {
				float: left;
				margin: 5px;
				position: absolute;
			}
		</style>
	</head>
	<body>
		<?php
			if (!isset($mobile))
			{
				echo "<p id='version'>";
				$querybtsversion = "SELECT value AS version FROM misc WHERE object = 'general' AND attribute = 'version';";
	        		$resultbtsversion = mysqli_query($db, $querybtsversion);
				$btsversion = mysqli_fetch_array($resultbtsversion);
				#DONOT delete this - You are allowed to change the link to your forked repo, otherwise keepit as it is
				echo "<a href='https://github.com/MDITSA/BeerTrackingSystem#readme' target='_blank'>BTS: " . htmlspecialchars($btsversion['version']) . "</a>";
				echo "</p>";
				echo "<center><h1>" . htmlspecialchars($heading) . "</h1></center>";
			}
			else
			{
				echo "<center><h1>" . htmlspecialchars($headingmobile) . "</h1></center>";
			}

			$querymotdactivation = "SELECT value AS activation FROM misc WHERE object = 'motd' AND attribute = 'activation';";
        		$resultmotdactivation = mysqli_query($db, $querymotdactivation);
			$motdactivation = mysqli_fetch_array($resultmotdactivation);

			if ( $motdactivation['activation'] == true)
			{
				echo "<center><h3>MotD: ";
				include 'motd.php';
				echo "</h3></center>";
			}
		?>

	<center>
	<table border="1" cellspacing="10">
		<tr>
			<td valign="top">
				<center>
				<table>
					<tr>
						<th><h2>Strike Status</h2></th>
					</tr>
				</center>

					<tr>
						<td><?php include 'current_strikes.php'; ?></td>
					</tr>
				</table>
			</td>

			<td valign="top">
				<center>
				<table>
					<tr>
						<th><h2>Current Stock</h2></th>
					</tr>
				</center>

					<tr>
						<td><?php include 'current_stock.php'; ?></td>
					</tr>
				</table>


				<form action="/update_stock.php" method="post">
                         		<?php
						echo "<br>";
						echo "<input type='number' name='newstock' style='width: 50px;'>";
						echo "<br>";
                                        	echo "<input type='submit' value='Update'>";
                        		?>
                		</form>
				
			</td>

			<?php
				if (!isset($mobile))
				{
                        		echo "<td valign='top'>
                                		<center>
                                		<table>
	                                        <tr>
        	                                        <th><h2>Beer Ranking</h2></th>
                	                        </tr>
                        		        </center>

						<tr>
							<td>";
							include 'top_ranking.php';
						echo "</td>
						</tr>

                                        	<tr>
							<td>";
									if (check_login($sessionid)[0] && check_login($sessionid)[1] == '0')
                                					{
		                 						echo '<a href="https://' . $_SERVER[HTTP_HOST] . '/ranking" target="_blank">Komplette Übersicht</a>';
                                					}
						echo "</td>
                                        	</tr>
                                		</table>
                        		</td>";
				}
			?>
		</tr>
	</table>
		<?php 
			if (check_login($sessionid)[0] && check_login($sessionid)[1] == '0')
                                {
                        		include 'index_add_del_strikes.php';
                                }
                                else
                                {
					echo '<br><br>';
                                        echo '<form action=".\validatelogin.php" method="post">
                                        <input type="text" id="name" name="name" placeholder="Name" required><br><br>
                                        <input type="password" id="password" name="password" placeholder="Passwort" required><br><br>
                                        <input type="submit" name="login" value="Login" />
                                        </form>';
				}
        		include 'pending_strikes.php';
			include 'veterans_visit.php';
		?>
	</center>

                <script src='support/overlay-widget.js'></script>
                <script>
                        kofiWidgetOverlay.draw('mditsa', {
                        'type': 'floating-chat',
                        'floating-chat.donateButton.text': 'Support me',
                        'floating-chat.donateButton.background-color': '#0011ff',
                        'floating-chat.donateButton.text-color': '#fff'
                        });
                </script>
	</body>
</html>
