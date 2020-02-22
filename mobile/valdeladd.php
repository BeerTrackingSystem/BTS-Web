<html>
        <head>
                <title>infra beer</title>
                <link rel="Favicon" href="favicon.ico" type="image/x-icon"/>
                <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        </head>
	<body>
		<?php
			$valcode = $_GET['valcode'];
		
		echo "<form action='/validatedeladd.php?valcode=$valcode' method='post'>
				<input type='submit' name='validation' value='Validate'>
		      </form>"
		?>
	</body>
</html>
