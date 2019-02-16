<?php
include 'sessionstart.php';
session_destroy();
$message = [];
array_push($message, "logged out");
echo JSON_encode($message);
 ?>
