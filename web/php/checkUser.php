<?php
include ('sessionstart.php');
include ('db_connect.php');
$message = [];

if ($_POST['userName']!= '' && $_POST['password'] != '') {
  try {
    foreach ($db->query('SELECT id FROM users WHERE username=\'' . $_POST['userName'] . '\'') as $userRow) {
      $_SESSION['user_id'] = $userRow['id'];
      foreach ($db->query('SELECT hash FROM credentials WHERE user_id=' . $userRow['id']) as $credentialRow) {
        if (password_verify($_POST['password'], $credentialRow['hash'])) {
          $_SESSION['userAuthorized'] = 'true';
          $_SESSION['user_id'] = $userRow['id'];
          array_push($message, 'true');
        } else {
          $_SESSION['userAuthorized'] = 'false';
          array_push($message, 'false1');
        }
      }
    }
  } catch (Exception $e) {
    session_destroy();
    $_SESSION = [];
    array_push($message, 'false2');
  }
} else {
  session_destroy();
  $_SESSION = [];
  array_push($message, "false4");
}
echo JSON_encode($message);
?>
