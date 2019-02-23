<?php
include ('sessionstart.php');
include ('db_connect.php');

try {
  // Get list of all users movies
  $query = 'SELECT * FROM user_movies WHERE user_id=:user_id';
  $statement = $db->prepare($query);
  $statement->bindValue('user_id', $_SESSION['user_id']);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
  $mergedObj = [];
  foreach ($results as $key=>$value) {
    // Get movie details for each movie in users database
    $query = 'SELECT * FROM movies WHERE id=:movie_id';
    $statement = $db->prepare($query);
    $statement->bindValue('movie_id', $value['movie_id']);
    $statement->execute();
    $result[$key] = $statement->fetchAll(PDO::FETCH_ASSOC);
    $mergedObj[$key] = (array) array_merge((array) $results[$key], (array) $result[$key][0]);

    //Get movie movie_statistics
    $query = 'SELECT user_rating, date_last_watched, times_watched FROM movie_statistics WHERE user_id=:user_id AND movie_id=:movie_id';
    $statement = $db->prepare($query);
    $statement->bindValue('user_id', $value['user_id']);
    $statement->bindValue('movie_id', $value['movie_id']);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // modify date format
    if ($result[0]['date_last_watched'] != '') {
      $result[0]['date_last_watched'] = date_format(date_create($result[0]['date_last_watched']), 'M d Y');
    } else {
      $result[0]['date_last_watched'] = 'Never Watched';
    }
    $mergedObj[$key] = (array) array_merge((array) $mergedObj[$key], (array) $result[0]);

    // Get movie Format
    $query = 'SELECT format FROM movie_format WHERE id=:media_format';
    $statement = $db->prepare($query);
    $statement->bindValue('media_format', $value['media_format']);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $mergedObj[$key] = (array) array_merge((array) $mergedObj[$key], (array) $result[0]);

    // Get Movie Genre's
    $query = 'SELECT genre_id FROM movie_genre WHERE movie_id=:movie_id';
    $statement = $db->prepare($query);
    $statement->bindValue('movie_id', $value['movie_id']);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $genre_results = [];
    foreach ($result as $key2=>$value2) {
      $query = 'SELECT genre FROM genre WHERE id=:genre_id';
      $statement = $db->prepare($query);
      $statement->bindValue('genre_id', $value2['genre_id']);
      $statement->execute();
      $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
      $genre_results[$key2] = (array) array_merge((array)$genre_results[$key2], $result2[0]);
      $mergedObj[$key]['genre'] = (array) array_merge((array) $mergedObj[$key]['genre'], (array) $genre_results[$key2]['genre']);
    }
  }
  echo json_encode($mergedObj);
} catch (Exception $e) {
  $_SESSION['userAuthorized'] = 'false';
  echo false;
  return;
}
?>
