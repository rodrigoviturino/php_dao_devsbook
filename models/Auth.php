<?php

require_once "DAO/UserDaoMysql.php";

class Auth {
  private $pdo; // está fazendo a conexão com o banco
  private $baseUrl;

  public function __construct(PDO $pdo, $base_url){
    $this->pdo = $pdo;
    $this->baseUrl = $base_url; 
  }

  public function checkToken(){
    // Verificando se o usuario tem token
    if( !empty($_SESSION["token"]) ){
      $token = $_SESSION["token"];
      // Buscando o token no banco para comparar se é o mesmo para prosseguir
      $userDao = new UserDaoMysql($this->pdo);
      $user = $userDao->findByToken($token);

      if($user) {
        return $user;
      }
    }

    header("Location: ".$this->baseUrl."/login.php");
    exit;

  }

  public function validateLogin($email, $password){
    $userDao = new UserDaoMysql($this->pdo);

    $user = $userDao->findByEmail($email);
    var_dump($user);
    if($user){

      if(password_verify($password, $user->password) ){
        $token = md5(time().rand(0, 9999));

        $_SESSION["token"] = $token;
        $user->token = $token;
        $userDao->update($user);

        return true;
      }

      return false;
    }

  }

}