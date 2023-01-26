<?php

namespace app\classes;

class User
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function password_verify($data, $password)
  {
    $sql = "SELECT B.password 
    FROM user_detail A 
    LEFT JOIN user_login B 
    ON A.id = B.user_id 
    WHERE B.name = ?
    AND A.status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    $row = $stmt->fetch();
    return  password_verify($password, $row['password']);
  }

  public function change_password($data)
  {
    $sql = "UPDATE user_login SET
    password = ?,
    updated = NOW()
    WHERE user_id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function user_detail_insert($data)
  {
    $sql = "INSERT INTO user_detail(name,email,contact) VALUES(?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function user_login_insert($data)
  {
    $sql = "INSERT INTO user_login(user_id,name,password,level) VALUES(?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt;
  }

  public function user_fetch($data)
  {
    $sql = "SELECT A.id user_id,A.name user_name,A.email user_email,A.contact user_contact,A.status user_status,
    B.name user_login,B.level user_level
    FROM user_detail A 
    LEFT JOIN user_login B 
    ON A.id = B.user_id
    WHERE A.id = ? OR B.name = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function last_insert_id()
  {
    return $this->dbcon->lastInsertId();
  }
}
