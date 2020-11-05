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

	$queryaddquote = "INSERT INTO quotes (quote, lastused) VALUES ('$quote', '2000-01-01');";
        $addquote = mysqli_query($db, $queryaddquote);

	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
