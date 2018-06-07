<?php

/* 
 * Root path, hhtp path and other define variable is declared here
 */

session_start();
$root_path = getcwd();
$url = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER['SCRIPT_NAME'];
$name = explode("/", $url);
$lastfile = end($name);
array_pop($name);
$urlpath = implode("/", $name) . "/";

define("http_path", $urlpath);
define("root_path", $root_path);
$includes_path = $root_path.'/includes/';
define("includes_path", $includes_path);

?>
<script>
    var urlpath = "<?php echo http_path; ?>";
</script>