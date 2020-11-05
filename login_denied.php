<?php
if (!defined('index_origin'))
{
    die('<h1>Direct File Access Prohibited</h1>');
}
?>
<script>
alert("Wrong User/Password");
location.replace('<?php echo "http://$_SERVER[HTTP_HOST]"; ?>')
</script>
