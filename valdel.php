<?php
if (!isset($_GET['valcode']))
{
	http_response_code(404);
	die();
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
		
		echo "<form action='/validatedel.php?valcode=" . htmlspecialchars($valcode) . "' method='post'>
				<input type='submit' name='validation' value='Validate'>
		      </form>"
		?>
	</body>
</html>
