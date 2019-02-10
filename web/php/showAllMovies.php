<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,POST");
session_start();

include ('db_connect.php');

try {
  $statement = $db->query('SELECT * FROM movies');
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($results);
} catch (Exception $e) {
  $_SESSION['userAuthorized'] = 'false';
  echo false;
  return;
}
?>
