<?php
include 'sessionstart.php';
include 'db_connect.php';

class format {
  public $format;
}

if (isset($_SESSION['user_id'])) {

  $query = ('SELECT movie_format_id FROM user_movie_format WHERE user_id=:userID');
  $statement = $db->prepare($query);
  $statement->bindValue(':userID', $_SESSION['user_id']);
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);

  $formatArray = [];
  foreach ($results as $key=>$row) {
    $f = new format;
    $query2 = ('SELECT format FROM movie_format WHERE id=:movie_id');
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':movie_id', $row['movie_format_id']);
    $statement2->execute();
    $results2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
    $f->format = $results2[0]['format'];
    $formatArray[$key] = $f;
  }

  echo JSON_encode($formatArray);
}

?>
