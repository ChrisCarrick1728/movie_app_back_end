<?php
session_start();
ini_set('session.gc_maxlifetime', 30*60);
if ($_SERVER['HTTP_ORIGIN'] === 'https://carrick-cs313-movie-app.herokuapp.com' || $_SERVER['HTTP_ORIGIN'] === 'http://localhost:8080') {
  header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
  header('Access-Control-Allow-Credentials: true');
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Methods: GET,POST");

} else {
  echo "I Like Fluffy Pillows :)";
  die();
}

class message {
  public $message;
}
?>
