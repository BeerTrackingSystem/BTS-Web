<?php
if (!defined('index_origin'))
{
	http_response_code(404);
	die();
}
?>
<?php
 $db = mysqli_connect('localhost','bts_test','bts_test','bts_test')
 or die('Error connecting to MySQL server.');
?>
