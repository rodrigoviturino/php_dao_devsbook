<?php

require_once "DAO/UserDaoMysql.php";

class Auth {
  private $pdo;
  private $baseUrl;

  public function __construct(PDO $pdo, $base_url){
    $this->pdo = $pdo;
    $this->baseUrl = $base_url; 
  }

  public function checkToken(){

    if( !empty($_SESSION["token"]) ){
      $token = $_SESSION["token"];

      $userDao = new UserDaoMysql($this->pdo);
      $user = $userDao->findByToken($token);

      if($user) {
        return $user;
      }
    }

    header("Location: ".$this->baseUrl."/login.php");
    exit;

  }

}