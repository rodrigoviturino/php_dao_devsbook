<?php

require_once "models/User.php";

class UserDaoMysql implements UserDAO {
  private $pdo;

  public function __construct(PDO $driver){
    $this->pdo = $driver;
  }

  public function generateUser($list){
    $user = new User();
    $user->id = $list['id'] ?? 0;
    $user->email = $list['email'] ?? '';
    $user->name = $list['name'] ?? '';
    $user->birthdate = $list['birthdate'] ?? '';
    $user->city = $list['city'] ?? '';
    $user->work = $list['work'] ?? '';
    $user->avatar = $list['avatar'] ?? '';
    $user->cover = $list['cover'] ?? '';

    return $user;
  }

  public function findByToken($token){
    if(!empty($token)){
      $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
      $sql->bindValue(":token", $token);
      $sql->execute();

      if($sql->rowCount() > 0 ){
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $user = $this->generateUser($sql);
        
        return $user;
      }      
      
    }    
  }

}