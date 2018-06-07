<?php

include '../core.php';

if(!empty($_SESSION) && array_key_exists("username", $_SESSION)){
    session_destroy();
    header("Location:http://auspiciousevents.in/");
}
?>

