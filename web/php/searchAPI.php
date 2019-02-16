<?php
include 'sessionstart.php';

class movie {
  public $title;
  public $overview;
  public $poster_path;
  public $genre_ids = [];
}



if (isset($_POST['search']) && $_POST['search'] != '') {
  $curl = curl_init();
  //urlencode($_POST['search'])
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?include_adult=false&page=1&query=" . urlencode($_POST['search']) . "&language=en-US&api_key=a727b0169f0031ebd41e13d140e8e430",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{}",
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "CURL Error #:" . $err;
  } else {
    $movieObj = [];
    $movieObj = json_decode($response, true);
    $newMovieObj = [];
    foreach ($movieObj['results'] as $key=>$value) {
      $m = new movie;
      $m->title = $value['title'];
      $m->overview = $value['overview'];
      if ($value['poster_path'] != '') {
        $m->poster_path = 'https://image.tmdb.org/t/p/w500/' . $value['poster_path'];
      } else {
        $m->poster_path = 'null';
      }
      $m->genre_ids = $value['genre_ids'];

      $newMovieObject[$key] = $m;
      // Return only 10 results;
      if ($key == 9) {
        break;
      }
    }

    echo JSON_encode($newMovieObject);
  }
} else {
  $m = new message;
  $m->message = "Empty Search Field.";
  echo JSON_encode($m);
}


?>
