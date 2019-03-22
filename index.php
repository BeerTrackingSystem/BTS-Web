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
		<center><h2>Strike Status</h2></center>

		<?php 
			include 'current_strikes.php';
			include 'index_add_del_strikes.php';
        		include 'pending_strikes.php';
		?>
	</body>
</html>
