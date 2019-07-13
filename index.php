<?php
	include 'db.inc.php';
?>

<html>
	<head>
		<title>infra beer</title>
		<link rel="Favicon" href="favicon.ico" type="image/x-icon"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	</head>
	<body>
		<center><h1>infra beer club</h1></center>

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
                </form></center>



			</td>
		</tr>
	</table>
	</center>
		<?php 
			include 'index_add_del_strikes.php';
        		include 'pending_strikes.php';
		?>
	</body>
</html>
