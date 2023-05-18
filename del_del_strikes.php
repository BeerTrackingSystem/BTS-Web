<?php
if (empty($_POST['id']))
{
	http_response_code(404);
	die();
}
?>
<?php
	define('index_origin', true);
        include 'db.inc.php';
?>

<?php
	include 'generate_del_pending_del_link.php';
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
