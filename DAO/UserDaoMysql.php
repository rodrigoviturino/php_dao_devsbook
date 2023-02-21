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

    // Verificando se o campo token não está vázio
    if(!empty($token)){
      $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
      $sql->bindValue(":token", $token);
      $sql->execute();

      // Verificando se encontrou algum usuario
      if($sql->rowCount() > 0 ){
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $user = $this->generateUser($sql);
        
        return $user;
      }      
      
    }    
  }

  public function findByEmail($email){
    if(!empty($email) ){
      $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
      $sql->bindValue(":email", $email);
      $sql->execute();

      if($sql->rowCount() > 0){
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $user = $this->generateUser($data);

        return $user;
      }

    }

    return false;
  }

  public function update(User $u){
    $sql = $this->pdo->prepare("UPDATE `users` SET
    `email` = :email,
    `password` = :password,
    `name` = :name,
    `birthdate` = :birthdate,
    `city` = :city,
    `work` = :work,
    `avatar` = :avatar,
    `cover` = :cover,
    `token` = :token
    WHERE `id` = :id");

    $sql->bindValue(':email', $u->email);
    $sql->bindValue(':password', $u->password);
    $sql->bindValue(':name', $u->name);
    $sql->bindValue(':birthdate', $u->birthdate);
    $sql->bindValue(':city', $u->city);
    $sql->bindValue(':work', $u->work);
    $sql->bindValue(':avatar', $u->avatar);
    $sql->bindValue(':cover', $u->cover);
    $sql->bindValue(':token', $u->token);
    $sql->bindValue(':id', $u->id);

    $sql->execute();
    return true;
  }

}