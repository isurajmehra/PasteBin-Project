<?php
session_start([
  'use_strict_mode' => 1,
  'use_only_cookies' => 1,
  'use_trans_sid' => 0,
  'cookie_lifetime' => 1800,
  'cookie_secure' => 1,
  'cookie_httponly' => 1
]);

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
  header("Location:index");
  die();
}

include_once("auth/auth.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $A = new Auth();
  if ($A->Login($username,$password)) {
    header("Location:../index");
  } else {
    $_SESSION["error"] = "Incorrect login details!";
  }
 }
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/slate/bootstrap.min.css" integrity="sha384-8iuq0iaMHpnH2vSyvZMSIqQuUnQA7QM+f6srIdlgBrTSEyd//AWNMyEaSF2yPzNQ" crossorigin="anonymous">
  <title>21Pastes</title>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body class="" style="background-color: #1c1e22; overflow-x: hidden">

  <?php include("navbar.php"); ?>

  <div class="container d-flex justify-content-center pt-5 mt-5 bg-dark shadow-lg" style="min-height: 100vh;">

    <div class="col-lg-10 cl-sm-12 p-0">
      <div class="container mb-4 mt-2 p-0">

        <div class="row">

          <div class="col-xs-6 col-sm-6 mb-4" style="margin: 0 auto;">

            <div class="card mb-4 box-shadow text-light" style="background-color: #1c1e22;">
              <div class="card-header" style="background-color: #1c1e22;">
                <h4 class="my-0 font-weight-normal">Login</h4>
              </div>
              <div class="card-body">
                <form method="POST">
                  <div class="form-group">
                    <label for="usernameInput">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                  </div>
                  <div class="form-group">
                    <label for="passwordInput">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                  </div>
                  <a href="register"><small>Dont have an account?</small> </a>

                  <?php
                  if(isset($_SESSION["error"])){
                      $error = $_SESSION["error"];
                      echo '<div class="alert alert-danger w-100" role="alert">' . $error . '</div>';
                      unset($_SESSION["error"]);
                    } else if(isset($_SESSION["success"])){
                        $success = $_SESSION["success"];
                        echo '<div class="alert alert-success w-100" role="alert">' . $success . '</div>';
                        unset($_SESSION["success"]);
                      }
                  ?>

                  <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                </form>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <?php include("footer.php"); ?>
</body>

</html>
