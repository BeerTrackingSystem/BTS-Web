<?php
        include '../db.inc.php';
?>

<?php
	$quote = $_POST['quote'];

	$queryaddquote = "INSERT INTO quotes (quote, lastused) VALUES ('$quote', '01.01.2000');";
        $addquote = mysqli_query($db, $queryaddquote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
