<?php
// Connection info string:
//    "dbname=dej82rdgudt0fr host=ec2-54-243-228-140.compute-1.amazonaws.com port=5432 user=wopxzqozvlgyon password=faf18081a5b8f8a25778e7ac36521851bf8bf65dc675a60962add90ae9abb604 sslmode=require"
// Connection URL:
//    postgres://wopxzqozvlgyon:faf18081a5b8f8a25778e7ac36521851bf8bf65dc675a60962add90ae9abb604@ec2-54-243-228-140.compute-1.amazonaws.com:5432/dej82rdgudt0fr

// try
// {
//   //$dbUrl = "localhost:5432";
//
//   //$dbOpts = parse_url($dbUrl);
//
//   $dbHost = "localhost";
//   $dbPort = "5432";
//   $dbUser = "movie_app";
//   $dbPassword = "testpass";
//   $dbName = "moviep_app_local";
//
//   $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
//
//   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $ex)
// {
//   echo 'Error!: ' . $ex->getMessage();
//   die();
// }

try
{
  $dbUrl = getenv('DATABASE_URL');

  $dbOpts = parse_url($dbUrl);

  $dbHost = $dbOpts["host"];
  $dbPort = $dbOpts["port"];
  $dbUser = $dbOpts["user"];
  $dbPassword = $dbOpts["pass"];
  $dbName = ltrim($dbOpts["path"],'/');

  $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}


?>
