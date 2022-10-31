<?php
session_start([
    'use_strict_mode' => 1,
    'use_only_cookies' => 1,
    'use_trans_sid' => 0,
    'cookie_lifetime' => 1800,
    'cookie_secure' => 1,
    'cookie_httponly' => 1
]);

require_once("mysqli_wrapper.php");

class Auth {

  public static function Login(string $username, string $password) : bool {
    $connection = new mysqli_wrapper();
    $query = $connection->query('SELECT * FROM `tbl_users` WHERE `username` = ?', [$username]);

    if ($query->num_rows === 0) {
      return false;
    }

    $result = $query->fetch_assoc();

    if (password_verify($password, $result["password"])) {
      $_SESSION["loggedin"] = true;
      $_SESSION['username'] = $username;
      $_SESSION["UID"] = $result["UID"];
      return true;
    } else {
      return false;
    }
  }

  public static function Access(string $password, string $pid) : bool {
    $connection = new mysqli_wrapper();
    $query = $connection->query('SELECT * FROM `tbl_pastes` WHERE `PID` = ?', [$pid]);

    if ($query->num_rows === 0) {
      return false;
    }

    $result = $query->fetch_assoc();

    if (password_verify($password, $result["password"])) {
      return true;
    } else {
      return false;
    }
  }

  public static function Register(string $username, string $password) : bool {
    $connection = new mysqli_wrapper();

    $query = $connection->query('SELECT * FROM `tbl_users` WHERE `username` = ?', [$username]);

    if ($query->num_rows !== 0) {
      return false;
    }

    $query = $connection->query('INSERT INTO `tbl_users` VALUES (NULL, ?, ?, current_timestamp())', [$username, $password]);

    return true;
  }
}
