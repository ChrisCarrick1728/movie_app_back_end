<?php
include 'sessionstart.php';
include 'db_connect.php';

try {
  $statement = $db->query('SELECT * FROM movie_genre');
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($results);
} catch (Exception $e) {
  $_SESSION['userAuthorized'] = 'false';
  echo false;
  return;
}
?>
