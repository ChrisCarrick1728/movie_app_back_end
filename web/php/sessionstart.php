<?php
session_start();
ini_set('session.gc_maxlifetime', 30*60);
header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,POST");

class message {
  public $message;
}
?>
