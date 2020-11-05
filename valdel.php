<?php
if (!isset($_GET['valcode']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<html>
        <head>
                <link rel="Favicon" href="favicon.ico" type="image/x-icon"/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        </head>
	<body>
		<?php
			$valcode = $_GET['valcode'];
		
		echo "<form action='/validatedel.php?valcode=$valcode' method='post'>
				<input type='submit' name='validation' value='Validate'>
		      </form>"
		?>
	</body>
</html>
