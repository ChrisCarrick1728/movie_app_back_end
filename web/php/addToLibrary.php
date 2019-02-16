<?php
include 'sessionstart.php';
include 'db_connect.php';

// params.append('title', this.searchResults[event.target.name]['title'])
// params.append('poster_url', this.searchResults[event.target.name]['poster_url'])
// params.append('overview', this.searchResults[event.target.name]['overview'])
// params.append('genre_ids', this.searchResults[event.target.name]['genre_ids'])
// params.append('format', this.searchResults[event.target.name]['format'])

if (isset($_POST['title']) && $_POST['title'] != '') {

  $movie_id = 0;

  // Update movies table
  try {
    $query = ('INSERT INTO movies(title, description, movie_poster_url) VALUES (:title, :description, :movie_poster_url)');
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $_POST['title']);
    $statement->bindValue(':description', $_POST['overview']);
    $statement->bindValue(':movie_poster_url', $_POST['poster_url']);
    $statement->execute();
    $movie_id = $db->lastInsertId(movies_id_seq);

    // Update movie_genre table
    try {
      $genre = explode(',', $_POST['genre_ids']);
      foreach($genre as $key=>$value) {
        $query = ('INSERT INTO movie_genre(movie_id, genre_id) VALUES (:movie_id, :genre_id)');
        $statement = $db->prepare($query);
        $statement->bindValue(':movie_id', $movie_id);
        $statement->bindValue(':genre_id', $value);
        $statement->execute();
      }
    } catch (Exception $e) {
      echo "Error3 " . $e;
      die();
    }
  } catch (Exception $e) {
    try {
      $query = ('SELECT id FROM movies WHERE title=:title');
      $statement = $db->prepare($query);
      $statement->bindValue(':title', $_POST['title']);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      //echo json_decode($result);
      $movie_id = $result[0]['id'];
    } catch (Exception $e) {
      echo "Error1" . $e;
      die();
    }
  }

  // Get format id
  try {
    $query = ('SELECT id FROM movie_format WHERE format=:format');
    $statement = $db->prepare($query);
    $statement->bindValue(':format', $_POST['format']);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $format_id = $result[0]['id'];
  } catch (Exception $e) {
    echo "error4 " . $e;
  }
  // Update user_movies table
  try {
    $query = ('INSERT INTO user_movies(movie_id, user_id, media_format) VALUES (:movie_id, :user_id, :media_format)');
    $statement = $db->prepare($query);
    $statement->bindValue(':movie_id', $movie_id);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':media_format', $format_id);
    $statement->execute();
  } catch (Exception $e) {
    echo "Error2 " . $e;
    die();
  }

  // Create movie movie_statistics
  try {
    $query = ('INSERT INTO movie_statistics(user_id, movie_id, times_watched) VALUES (:user_id, :movie_id, :time_watched)');
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':movie_id', $movie_id);
    $statement->bindValue(':time_watched', '0');
    $statement->execute();

  } catch (Exception $e) {
    echo "Error5 " . $e;
  }

}
echo "success";

?>
