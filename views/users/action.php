<?php

use app\classes\System;
use app\classes\User;
use app\classes\Validation;

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set("Asia/Bangkok");

require_once(__DIR__ . "/../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : "");
$param1 = (isset($param[1]) ? $param[1] : "");
$param2 = (isset($param[2]) ? $param[2] : "");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$Users = new User();
$Systems = new System();
$Validation = new Validation();

$system = $Systems->fetch();

if ($action === "create") :
  try {
    $login = (isset($_POST['login']) ? $Validation->input($_POST['login']) : "");
    $name = (isset($_POST['name']) ? $Validation->input($_POST['name']) : "");
    $email = (isset($_POST['email']) ? $Validation->input($_POST['email']) : "");
    $contact = (isset($_POST['contact']) ? $Validation->input($_POST['contact']) : "");
    $level = (isset($_POST['level']) ? $Validation->input($_POST['level']) : "");
    $password = $system['default_password'];
    $options = ["cost" => 15, "salt" => "ceb20772e0c9d240c75eb26b0e37abee"];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    if (!empty($email)) {
      $format_email = $Validation->email($email);
      if (!$format_email) {
        $Validation->alert("danger", "รูปแบบอีเมล์ไม่ถูกต้อง กรุณาตรวจสอบข้อมูล", "/users");
      }
    }

    $Users->user_detail_insert([$name, $email, $contact]);
    $user_id = $Users->last_insert_id();
    $Users->user_login_insert([$user_id, $login, $hash, $level]);

    $Validation->alert("success", "เพิ่มข้อมูลเรียบร้อย", "/users");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;

if ($action === "change") :
  try {
    $password = (isset($_POST['password']) ? $Validation->input($_POST['password']) : "");
    $password2 = (isset($_POST['password2']) ? $Validation->input($_POST['password2']) : "");
    $options = ["cost" => 15, "salt" => "ceb20772e0c9d240c75eb26b0e37abee"];
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    if ($password != $password2) {
      $Validation->alert("danger", "รหัสผ่านไม่เหมือนกัน กรุณากรอกอีกครั้ง", "/users/profile");
    }

    $Users->change_password([$hash, $user_id]);

    $Validation->alert("success", "ดำเนินการเรียบร้อย", "/users/profile");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
endif;
