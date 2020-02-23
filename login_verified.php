<?php
	$username = $_GET['username'];
	$cookie_value = "yes-$username";
        setcookie('veteran', $cookie_value, time() +3600);
	header("Location: http://$_SERVER[HTTP_HOST]");	
?>
