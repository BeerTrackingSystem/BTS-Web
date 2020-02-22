<?php
        include 'db.inc.php';
?>

<?php
	include 'generate_del_pending_add_link.php';
	header("Location: http://$_SERVER[HTTP_HOST]");
?>
