<?php
if (empty($_POST['quote']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include '../db.inc.php';
?>

<?php
	$quote = $_POST['quote'];
	$defaultdate = '2000-01-01';

	$queryaddquote = "INSERT INTO quotes (quote, lastused) VALUES (?, ?);";
	$prepaddquote = mysqli_prepare($db, $queryaddquote);
	mysqli_stmt_bind_param ($prepaddquote, 'ss', $quote, $defaultdate);
	mysqli_stmt_execute($prepaddquote);
	$resultaddquote = mysqli_stmt_get_result($prepaddquote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
