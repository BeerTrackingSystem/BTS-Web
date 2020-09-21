<?php
if (!defined('SECURE_PAGE'))
{
    die(http_response_code(404));
}
?>
<?php
	$cookie_value = "yes-$username";
        setcookie('user', $cookie_value, time() +3600);
	header("Location: http://$_SERVER[HTTP_HOST]");	
?>
