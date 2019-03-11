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
?>

<br>
		<center><h2>Add Strike</h2></center>
		<form action="/add_strikes.php" method="post">
  			<input type="submit" value="Mario" name="user">
  			<input type="submit" value="Patrick" name="user">
  			<input type="submit" value="Lenny" name="user">
  			<input type="submit" value="Steffen" name="user">
		</form>

<br>
		<center><h2>Del Strike</h2></center>
		<form action="/del_strikes.php" method="post">
  			<input type="submit" value="Mario" name="user">
  			<input type="submit" value="Patrick" name="user">
  			<input type="submit" value="Lenny" name="user">
  			<input type="submit" value="Steffen" name="user">
		</form>

<br>

<?php
        include 'pending_strikes.php';
?>
	</body>
</html>
