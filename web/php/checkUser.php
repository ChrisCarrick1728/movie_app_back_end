<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,POST");
session_start();

include ('db_connect.php');

if (isset($_POST['userName']) && isset($_POST['password'])) {
  try {
    foreach ($db->query('SELECT id, salt FROM users WHERE username=\'' . $_POST['userName'] . '\'') as $userRow)
    {
      foreach ($db->query('SELECT hash FROM credentials WHERE user_id=' . $userRow['id']) as $credentialRow) {
        // todo: compare hash's
        $_SESSION['userAuthorized'] = 'true';
        echo true;
        return;
      }
    }

  } catch (Exception $e) {
    $_SESSION['userAuthorized'] = 'false';
    echo false;
    return;
  }
  echo false;
  return;
} else {
  $_SESSION['userAuthorized'] = 'false';
  echo false;
  return;
}
?>
