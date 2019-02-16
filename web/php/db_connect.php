<?php

if ($_SERVER['HTTP_ORIGIN'] == 'http://localhost:8080' || !isset($_SERVER['HTTP_ORIGIN'])) {
  try {
    $dbHost = "localhost";
    $dbPort = "5432";
    $dbUser = "movie_app";
    $dbPassword = "testpass";
    $dbName = "moviep_app_local";

    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $ex)
  {
    echo 'Local Error!: ' . $ex->getMessage();
    die();
  }
} else {
  try {
    $dbUrl = getenv('DATABASE_URL');
    //echo "dbURL: " . $dbUrl;
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
    echo 'Remote Error!: ' . $ex->getMessage();
    die();
  }
}


?>
