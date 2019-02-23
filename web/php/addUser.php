<?php
include 'sessionstart.php';
include 'db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$vPassword = $_POST['vPassword'];
$email = $_POST['email'];
$error = false;
$message = [];

try {
  if (checkUserExists($username, $db)) {
    array_push($message, "Username has been taken.");
    $error = true;
  }
  if (checkEmailExists($email, $db)) {
    array_push($message, "An account with that email already exisits.");
    $error = true;
  }
  if ($password != $vPassword) {
    array_push($message, "Passwords do not match.");
    $error = true;
  }

  if (!$error) {
    $usersQuery = 'INSERT INTO users(username, email) VALUES (:username, :email)';
    $usersStatement = $db->prepare($usersQuery);
    $usersStatement->bindValue(':username', $username);
    $usersStatement->bindValue(':email', $email);
    $usersStatement->execute();

    $user_id = $db->lastInsertId('users_id_seq');
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $credentialsQuery = 'INSERT INTO credentials(user_id, hash) VALUES (:user_id, :hash)';
    $credentialsStatement = $db->prepare($credentialsQuery);
    $credentialsStatement->bindValue(':user_id', $user_id);
    $credentialsStatement->bindValue(':hash', $hash);
    $credentialsStatement->execute();
    array_push($message, "Account created successfully.");
  }
} catch (Exception $e) {
}

echo JSON_encode($message);

function checkUserExists($user, $db) {
  $query = 'SELECT username FROM users WHERE username=:username';
  $statement = $db->prepare($query);
  $statement->bindValue(':username', $user);
  $statement->execute();
  if ($statement->rowCount() >= 1) {
    return true;
  }
  return false;
}

function checkEmailExists($email, $db) {
  $query = 'SELECT email FROM users WHERE email=:email';
  $statement = $db->prepare($query);
  $statement->bindValue(':email', $email);
  $result = $statement->execute();
  if ($statement->rowCount() >= 1) {
    return true;
  }
  return false;
}
?>
