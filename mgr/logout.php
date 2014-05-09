<?php
require_once(dirname(__FILE__).'/inc/config.inc.php');

$_SESSION = array();
session_destroy();
header('location:login.php');
exit();
?>