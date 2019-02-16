<?php
include 'sessionstart.php';
include 'db_connect.php';


$query = ('SELECT id FROM movies WHERE title=:title');
$statement = $db->prepare($query);
$statement->bindValue(':title', $_POST['title']);
$statement->execute();
$result = $statement->fetchALL(PDO::FETCH_ASSOC);

$movie_id = $result[0]['id'];

$query = ('SELECT times_watched FROM movie_statistics WHERE movie_id=:movie_id AND user_id=:user_id');
$statement = $db->prepare($query);
$statement->bindValue(':movie_id', $movie_id);
$statement->bindValue(':user_id', $_SESSION['user_id']);
$statement->execute();
$result = $statement->fetchALL(PDO::FETCH_ASSOC);

$timesWatched = $result[0]['times_watched'];
echo "timeswatched: " . $timesWatched;
$timesWatched++;

$query = ('UPDATE movie_statistics SET date_last_watched=:date_last_watched, times_watched=:times_watched WHERE (user_id=:user_id AND movie_id=:movie_id)');
$statement = $db->prepare($query);
$nDate = getdate();
$statement->bindValue(':date_last_watched', $nDate[year] . '\\' . $nDate[mon] . '\\' . $nDate[mday]);
$statement->bindValue(':times_watched', $timesWatched++);
$statement->bindValue(':movie_id', $movie_id);
$statement->bindValue(':user_id', $_SESSION['user_id']);
$statement->execute();

?>
