<?php
include 'sessionstart.php';
$message = [];

if ($_SESSION['userAuthorized'] == 'true' && isset($_SESSION['user_id'])) {
  // Check for user timeout
  // Verify same Origin
  array_push($message, 'true');
} else {
  $_SESSION = [];
  session_destroy();
  array_push($message, 'false');
}

echo JSON_encode($message);
 ?>
