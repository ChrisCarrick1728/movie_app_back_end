CREATE TABLE users (
  id                serial            primary key,
  username          varchar(20)       UNIQUE,
  email             varchar(255)      UNIQUE
);

CREATE TABLE credentials (
  id                serial            primary key,
  user_id           int               references users(id),
  hash              text
);

CREATE TABLE movies (
  id                serial            primary key,
  title             varchar(255)      NOT NULL UNIQUE,
  description       text              NOT NULL,
  movie_poster_url  varchar(255)      NOT NULL
);

CREATE TABLE movie_format (
  id                serial            primary key,
  format            varchar(255)      NOT NULL UNIQUE -- Ex. DVD, BLURAY, Itunes, Amazon Prime, etc...
);

CREATE TABLE user_movie_format (
  movie_format_id   int               references movie_format(id) NOT NULL,
  user_id           int               references users(id) NOT NULL
);

CREATE TABLE genre (
  id                serial            primary key,
  genre             varchar(255)      NOT NULL UNIQUE
);

CREATE TABLE movie_genre (
  id                serial           ,
  movie_id          int              references movies(id) NOT NULL,
  genre_id          int              references genre(id) NOT NULL
);

CREATE TABLE user_movies (
  id                serial            primary key,
  movie_id          int               references movies(id) NOT NULL,
  user_id           int               references users(id) NOT NULL,
  media_format      int               references movie_format(id) NOT NULL
);

CREATE TABLE movie_statistics (
  id                serial            NOT NULL,
  user_id           int               references users(id) NOT NULL,
  movie_id          int               references movies(id) NOT NULL,
  user_rating       int,
  date_last_watched date,
  times_watched     int
);


INSERT INTO users(username, salt, email) VALUES ('testuser', 'testsalt', 'testemail@email.com');
INSERT INTO users(username, salt, email) VALUES ('testuser2', 'testsalt2', 'testemail2@email.com');
INSERT INTO users(username, salt, email) VALUES ('testuser3', 'testsalt3', 'testemail3@email.com');

INSERT INTO credentials(user_id, hash) VALUES ('1', 'testhash');
INSERT INTO credentials(user_id, hash) VALUES ('2', 'testhash2');
INSERT INTO credentials(user_id, hash) VALUES ('3', 'testhash3');

INSERT INTO movies(title, description, movie_poster_url) VALUES ('Jason Bourne', 'The most dangerous former operative of the CIA is drawn out of hiding to uncover hidden truths about his past.', 'https://image.tmdb.org/t/p/w500/lFSSLTlFozwpaGlO31OoUeirBgQ.jpg');
INSERT INTO movies(title, description, movie_poster_url) VALUES ('Jason Bourne1', 'The most dangerous former operative of the CIA is drawn out of hiding to uncover hidden truths about his past.', 'https://image.tmdb.org/t/p/w500/lFSSLTlFozwpaGlO31OoUeirBgQ.jpg');
INSERT INTO movies(title, description, movie_poster_url) VALUES ('Jason Bourne2', 'The most dangerous former operative of the CIA is drawn out of hiding to uncover hidden truths about his past.', 'https://image.tmdb.org/t/p/w500/lFSSLTlFozwpaGlO31OoUeirBgQ.jpg');
INSERT INTO movies(title, description, movie_poster_url) VALUES ('Jason Bourne3', 'The most dangerous former operative of the CIA is drawn out of hiding to uncover hidden truths about his past.', 'https://image.tmdb.org/t/p/w500/lFSSLTlFozwpaGlO31OoUeirBgQ.jpg');

INSERT INTO movie_format(format) VALUES ('DVD');
INSERT INTO movie_format(format) VALUES ('BluRay');
INSERT INTO movie_format(format) VALUES ('iTunes');

INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('1', '1');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('2', '1');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('3', '1');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('1', '2');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('2', '2');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('3', '2');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('1', '15');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('2', '15');
INSERT INTO user_movie_format(movie_format_id, user_id) VALUES ('3', '15');




INSERT INTO movie_genre(movie_id, genre_id) VALUES ('1', '1');
INSERT INTO movie_genre(movie_id, genre_id) VALUES ('2', '1');
INSERT INTO movie_genre(movie_id, genre_id) VALUES ('2', '2');
INSERT INTO movie_genre(movie_id, genre_id) VALUES ('3', '4');
INSERT INTO movie_genre(movie_id, genre_id) VALUES ('4', '6');
INSERT INTO movie_genre(movie_id, genre_id) VALUES ('4', '5');
INSERT INTO movie_genre(movie_id, genre_id) VALUES ('4', '3');

INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('1', '1', '3');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('2', '1', '3');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('3', '1', '3');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('4', '1', '3');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('1', '2', '1');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('2', '2', '2');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('3', '2', '1');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('4', '2', '2');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('1', '3', '2');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('2', '3', '2');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('3', '3', '2');
INSERT INTO user_movies(movie_id, user_id, media_format) VALUES ('4', '3', '2');

INSERT INTO movie_statistics(user_id, movie_id, user_rating, date_last_watched, times_watched) VALUES ('1', '1', '9', '2019-01-23', '1');
INSERT INTO movie_statistics(user_id, movie_id, user_rating, date_last_watched, times_watched) VALUES ('1', '2', '8', '2019-01-23', '2');
INSERT INTO movie_statistics(user_id, movie_id, user_rating, date_last_watched, times_watched) VALUES ('2', '3', '7', '2019-01-23', '3');
INSERT INTO movie_statistics(user_id, movie_id, user_rating, date_last_watched, times_watched) VALUES ('2', '4', '6', '2019-01-23', '4');
INSERT INTO movie_statistics(user_id, movie_id, user_rating, date_last_watched, times_watched) VALUES ('3', '1', '5', '2019-01-23', '5');
INSERT INTO movie_statistics(user_id, movie_id, user_rating, date_last_watched, times_watched) VALUES ('3', '2', '4', '2019-01-23', '6');

SELECT * FROM user_movies, movie_statistics, movie_genre, movie_format INNER JOIN user_movies, movie_statistics ON user_movies.user_id='1');


