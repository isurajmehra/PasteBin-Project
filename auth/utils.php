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

class Utils {

  function throwError($err) {
    $_SESSION["error"] = $err;
    header("Location:../index");
    die();
  }

  function throwRegisterError($err) {
    $_SESSION["error"] = $err;
    header("Location:../register");
    die();
  }

  function secToDaysHoursMinutes($seconds) {
    $days = floor($seconds/86400);
    $hours = floor(($seconds - $days*86400) / 3600);
    $minutes = floor(($seconds / 60) % 60);
    return "$days days, $hours hours, $minutes minutes";
  }

  function sizeOfText($text)
  {
      $bytes = strlen($text);
      $logBase = log($bytes, 1024);
      $suffixes = array('Bytes', 'KB', 'MB', 'GB', 'TB');
      return round(pow(1024, $logBase - floor($logBase)), 2) .' '. $suffixes[floor($logBase)];
  }

  public static function CheckCaptcha(string $captcha) : bool {

    $data = array(
        'secret' => "0x464bAaF0b9EB3EcA6FAe758F1aA2252D9b90beA4",
        'response' => $captcha
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $responseData = json_decode($response);
    if (!$responseData->success) {
      return false;
    }

    return true;
  }

  public static function Post(string $title, string $text, string $password, string $expiry, string $syntax) : int {

    switch($expiry){
      case 1: $expiry = -1; break;
      case 2: $expiry = time() + 86400; break;
      case 3: $expiry = time() + 172800; break;
      case 4: $expiry = time() + 604800; break;
    }

    switch($syntax){
      case 1: $syntax = "txt"; break;
      case 2: $syntax = "html"; break;
      case 3: $syntax = "php"; break;
      case 4: $syntax = "sql"; break;      
	  case 5: $syntax = "cpp"; break;	  
	  case 6: $syntax = "js"; break;

    }

    $connection = new mysqli_wrapper();
    $query = $connection->query('INSERT INTO `tbl_pastes` VALUES (NULL, ?, ?, ?, current_timestamp(), ?,?)', [$title, $text, $syntax, $expiry, $password]);

    $query = $connection->query('SELECT * FROM `tbl_pastes` WHERE `timestamp` = current_timestamp()');

    $result = $query->fetch_assoc();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
      $query = $connection->query('INSERT INTO `tbl_posts` VALUES (?, ?)', [$_SESSION["UID"], $result["PID"]]);
    }

    return $result["PID"];
  }

  public static function Edit(string $text, int $pid) {

    $connection = new mysqli_wrapper();
    $query = $connection->query('UPDATE `tbl_pastes` SET `text`= ? WHERE `PID` = ?', [$text, $pid]);
  }

  public static function Delete(string $pid) {

    $connection = new mysqli_wrapper();
    $query = $connection->query('DELETE FROM `tbl_pastes` WHERE `PID` = ?', [$pid]);
    $query = $connection->query('DELETE FROM `tbl_posts` WHERE `PID` = ?', [$pid]);
  }

}
