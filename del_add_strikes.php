<?php
if (empty($_POST['id']))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>

<?php
	include 'generate_del_pending_add_link.php';
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
