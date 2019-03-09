<?php
	include 'db.inc.php';
?>

<html>
	<head>
		<title>infra beer</title>
	</head>
	<body>
		<center><h1>infra beer club</h1></center>
		<center><h2>Status</h2></center>

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

	</body>
</html>
