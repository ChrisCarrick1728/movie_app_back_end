<?php
session_start();
ini_set('session.cookie_secure','On');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,POST");




//echo "user_id: " . session_status() . " " . session_id();
$_SESSION['user_id'] = 1;
include ('db_connect.php');

try {
  $statement = $db->query('SELECT * FROM user_movies WHERE user_id=\'' . $_SESSION['user_id'] . '\'');
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  $mergedObj = [];
  foreach ($results as $key=>$value) {
    $movie_statement = $db->query('SELECT * FROM movies WHERE id=\'' . $value['movie_id'] . '\'');
    $movie_results[$key] = $movie_statement->fetchALL(PDO::FETCH_ASSOC);
    $mergedObj[$key] = (array) array_merge((array) $results[$key], (array) $movie_results[$key][0]);

    $movie_stat_statement = $db->query('SELECT user_rating, date_last_watched, times_watched FROM movie_statistics WHERE user_id=\'' . $value['user_id'] . '\' AND movie_id=\'' . $value['movie_id'] . '\'');
    $movie_stat_results = $movie_stat_statement->fetchALL(PDO::FETCH_ASSOC);
    //echo json_encode($movie_stat_results[$key]);
    $mergedObj[$key] = (array) array_merge((array) $mergedObj[$key], (array) $movie_stat_results[0]);

    $movie_format_statement = $db->query('SELECT format FROM movie_format WHERE id=\'' . $value['media_format'] . '\'');
    $movie_format_results = $movie_format_statement->fetchALL(PDO::FETCH_ASSOC);
    $mergedObj[$key] = (array) array_merge((array) $mergedObj[$key], (array) $movie_format_results[0]);

    $movie_genre_statement = $db->query('SELECT genre_id FROM movie_genre WHERE movie_id=\'' . $value['movie_id'] . '\'');
    $movie_genre_results = $movie_genre_statement->fetchALL(PDO::FETCH_ASSOC);
    $genre_results = [];
    foreach ($movie_genre_results as $key2=>$value2) {
      //echo json_encode($value2) . " - " . $key2 . ",  " ;
      $genre_statement = $db->query('SELECT genre FROM genre WHERE id=\'' . $value2['genre_id']  . '\'');
      $query = $genre_statement->fetchALL(PDO::FETCH_ASSOC);
      $genre_results[$key2] = (array) array_merge((array)$genre_results[$key2], $query[0]);
      //echo json_encode($genre_results[$key2]['genre']);
      $mergedObj[$key]['genre'] = (array) array_merge((array) $mergedObj[$key]['genre'], (array) $genre_results[$key2]['genre']);
      foreach ($genre_results as $key3=>$value3) {
        //echo json_encode($value3) . " - " . $key3 . ",  " ;

        //echo json_encode($value3) . "</br></br>";
      }

    }
    //echo json_encode($genre_results);
    //$mergedObj = (array) array_merge((array) $mergedObj, (array) $genre_results);
    //echo " </br></br> ";

  }



  echo json_encode($mergedObj);
} catch (Exception $e) {
  $_SESSION['userAuthorized'] = 'false';
  echo false;
  return;
}
?>
