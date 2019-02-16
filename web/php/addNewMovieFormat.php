<?php
include 'sessionstart.php';
include 'db_connect.php';

if (isset($_POST['movie_format']) && $_POST['movie_format'] != '') {
  $movie_format_id = 0;
  $messageArray = [];

  // Check if format is in movie_format table
  $formatQuery = ('SELECT * FROM movie_format WHERE format=:format');
  $formatStatement = $db->prepare($formatQuery);
  $formatStatement->bindValue(':format', $_POST['movie_format']);
  $formatStatement->execute();
  $formatResults = $formatStatement->fetchAll(PDO::FETCH_ASSOC);

  // If not in main movie_format table add it now
  if (sizeof($formatResults) == 0) {
    $query = ('INSERT INTO movie_format(format) VALUES (:format)');
    $statement = $db->prepare($query);
    $statement->bindValue(':format', $_POST['movie_format']);
    $statement->execute();
    $movie_format_id = $db->lastInsertId(movie_format_id_seq);
    $m = new message;
    $m->message = "Format added to db";
    array_push($messageArray, $m);
  } else {
    $movie_format_id = $formatResults[0]['id'];
    $m = new message;
    $m->message = "Format already in db";
    array_push($messageArray, $m);
  }

  // Check if format is already associated with a user
  $userFormatQuery = ('SELECT movie_format_id FROM user_movie_format WHERE user_id=:user_id AND movie_format_id=:movie_format_id');
  $userFormatStatement = $db->prepare($userFormatQuery);
  $userFormatStatement->bindValue(':user_id', $_SESSION['user_id']);
  $userFormatStatement->bindValue(':movie_format_id', $movie_format_id);
  $userFormatStatement->execute();
  $userFormatResults = $userFormatStatement->fetchAll(PDO::FETCH_ASSOC);

  // If not in user_movie_format WHERE user_id == current user_id add to user_movie_format
  if (sizeof($userFormatResults) == 0) {
    $query = ('INSERT INTO user_movie_format(movie_format_id, user_id) VALUES (:movie_format_id, :user_id)');
    $statement = $db->prepare($query);
    $statement->bindValue(':movie_format_id', $movie_format_id);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $m = new message;
    $m->message = "Format added to userdb";
    array_push($messageArray, $m);
  } else {
    $m = new message;
    $m->message = "Format already in userdb";
    array_push($messageArray, $m);
  }

  echo json_encode($messageArray);
}
?>
