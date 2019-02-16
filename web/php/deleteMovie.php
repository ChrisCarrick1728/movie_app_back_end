<?php
include 'sessionstart.php';
include 'db_connect.php';
if (isset($_POST['title']) && $_POST['title'] != '') {
  try {
    $query = ('SELECT id FROM movies WHERE title=:title');
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $_POST['title']);
    $statement->execute();
    $result = $statement->fetchALL(PDO::FETCH_ASSOC);

    $movie_id = $result[0]['id'];

    $query = ('DELETE FROM user_movies WHERE user_id=:user_id AND movie_id=:movie_id');
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':movie_id', $movie_id);
    $statement->execute();

    $query = ('DELETE FROM movie_statistics WHERE user_id=:user_id AND movie_id=:movie_id');
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':movie_id', $movie_id);
    $statement->execute();
  } catch (Exception $e) {
    //echo "error: " . $e;
  }
}
?>
