<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<script>
alert("Wrong User/Password");
location.replace('<?php echo "http://$_SERVER[HTTP_HOST]"; ?>')
</script>
