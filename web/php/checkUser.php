<?php
include ('sessionstart.php');

//echo "Origin " . $_SERVER['HTTP_ORIGIN'] . "    ";
include ('db_connect.php');
echo "user_id: " . session_status() . " " . session_id();
if (isset($_POST['userName']) && isset($_POST['password'])) {
  try {
    foreach ($db->query('SELECT id, salt FROM users WHERE username=\'' . $_POST['userName'] . '\'') as $userRow)
    {
      $_SESSION['user_id'] = $userRow['id'];
      //echo "user_id: " . $_SESSION['user_id'];
      foreach ($db->query('SELECT hash FROM credentials WHERE user_id=' . $userRow['id']) as $credentialRow) {
        // todo: compare hash's
        $_SESSION['userAuthorized'] = 'true';
        $_SESSION['user_id'] = $userRow['id'];
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
