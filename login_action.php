<?php
  require "config.php";
  require "models/Auth.php";

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

  if($email && $password){

    $auth = new Auth($pdo, $base_url);
    if($auth->validateLogin($email, $password)){
      header("Location: ".$base_url);
      exit;
    }
  }

  $_SESSION['flash'] = '<h4>E-mail e/ou senha inválidos.</h4>';

  header("Location: ".$base_url."/login.php");
  exit;

?>