<?php
session_start([
  'use_strict_mode' => 1,
  'use_only_cookies' => 1,
  'use_trans_sid' => 0,
  'cookie_lifetime' => 1800,
  'cookie_secure' => 1,
  'cookie_httponly' => 1
]);

include_once("auth/utils.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $Utils = new Utils();

  $title = $_POST["TitleInput"];
  $text = $_POST["PasteInput"];
  $password = $_POST["PasswordInput"];
  $cpassword = $_POST["ConfirmPassword"];
  $expiry = $_POST["TimeInput"];
  $syntax = $_POST["SyntaxInput"];
  $captcha = $_POST['h-captcha-response'];

  $text = htmlspecialchars($text);

  if (!$Utils->CheckCaptcha($captcha)) {
    $Utils->throwError("Failed hCaptcha!");
  }

  if ($title === "") {
    $Utils->throwError("Title is blank!");
  } else if (strlen($title) > 32) {
    $Utils->throwError("Title is too long!");
  } else if ($text === "") {
    $Utils->throwError("Paste is blank!");
  }
  if ($password === ''){

  } else if (strcmp($password, $cpassword) === 0) {
    $password = password_hash($password, PASSWORD_DEFAULT);
  } else {
    $Utils->throwError("Passwords do not match!");
  }

  $p = $Utils->Post($title, $text, $password, $expiry, $syntax);
  $_SESSION["auth"] = true;
  header("Location:../text/" . $p);
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
  <script src='https://www.hCaptcha.com/1/api.js' async defer></script>

  <style>
    .hiddenelem {
      display: none;
    }

    .hiddenelem2 {
      display: none;
    }

    .hiddenelem3 {
      display: none;
    }

    textarea {
      resize: none;
    }
  </style>

</head>

<body class="" style="background-color: #1c1e22; overflow-x: hidden">

  <?php include("navbar.php"); ?>

  <div class="container d-flex justify-content-center pt-5 mt-5 bg-dark shadow-lg" style="min-height: 100vh;">

    <div class="col-lg-10 cl-sm-12 p-0">
      <div class="container mb-4 mt-2 p-0">

        <div class="card text-white bg-dark shadow " style="background-color: #1c1e22;">
          <div class="card-body" style="background-color: #1c1e22;">
            <div class="row no-gutters align-items-center">
              <div class="mr-2">
                <?php
if(isset($_SESSION["error"])){
    $error = $_SESSION["error"];
    echo '<div class="text-xs font-weight-bold text-uppercase mb-1"><span style="color: red;">Error</span></div>';
    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $error . '</div>';
    unset($_SESSION["error"]);
  }
  else {
    echo '<div class="text-xs font-weight-bold text-uppercase mb-1"><span style="color: pink;">Welcome</span></div>';
    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">Welcome to 21Pastes - Click <a href="public"><span style="color: pink;">Here</span></a> To View Public Pastes</div>';
  }
?>
              </div>
            </div>
          </div>
        </div>

        <div class="card mt-4 box-shadow text-light" style="background-color: #1c1e22;">
          <div class="card-header" style="background-color: #1c1e22;">
            <h4 class="my-0 font-weight-normal">Paste Here!</h4>
          </div>
          <div class="card-body overflow-auto p-2" id="messageBody" style="height: auto; max-height: auto; background-color: #1c1e22;">

            <form class="m-3" id="f1" method="POST" autocomplete="off">
              <div class="form-group w-100">
                <input type="text" class="form-control mt-2" id="TitleInput" name="TitleInput" placeholder="Title Input" autocomplete="off">
              </div>
              <div class="form-group">
                <textarea class="form-control" id="PasteInput" name="PasteInput" rows="15" placeholder="Paste Area"></textarea>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="HighlightPaste" name="HighlightPaste" value="highlight">
                <label class="form-check-label" for="inlineCheckbox1">Highlight Syntax</label>
              </div>
              <div class="btn-group">
                <select class="form-control mt-2 mb-2 hiddenelem3" id="SyntaxInput" name="SyntaxInput">
                  <option value="1" hidden>Choose syntax</option>
                  <option value="2">HTML</option>
                  <option value="3">PHP</option>
                  <option value="4">SQL</option>                  
				  <option value="5">C++</option>				  
				  <option value="6">JS</option>


                </select>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="ExpirePaste" name="ExpirePasta" value="expire">
                <label class="form-check-label" for="inlineCheckbox1">Expire</label>
              </div>
              <div class="btn-group">
                <select class="form-control mt-2 mb-2 hiddenelem2" id="TimeInput" name="TimeInput">
                  <option value="1" hidden>Expires Never</option>
                  <option value="2">Expire in 24 hours</option>
                  <option value="3">Expire in 48 hours</option>
                  <option value="4">Expire in 1 week</option>
                </select>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="PrivatePaste" name="PrivatePasta" value="private">
                <label class="form-check-label" for="inlineCheckbox1">Private</label>
              </div>
              <div class="form-group w-50">
                <input type="password" class="form-control mt-2 hiddenelem" id="PasswordInput" name="PasswordInput" placeholder="Password" autocomplete="off">
                <input type="password" class="form-control mt-2 hiddenelem" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password" autocomplete="off">
              </div>

              <div class="h-captcha" data-sitekey="a229eb84-744a-44aa-a9ab-a50f8bb761b1"></div>

              <button type="submit" class="btn btn-primary mt-2 mb-2 w-25">Post your Paste!</button>
            </form>

          </div>

        </div>
      </div>
    </div>
  </div>

  <?php include("footer.php"); ?>

  <script>
    $("#ExpirePaste").change(function() {
      var bIsChecked = $(this).is(':checked');

      if (bIsChecked === true) {
        $("#TimeInput").show();
      } else {
        $("#TimeInput").hide();
      }
    })

    $("#PrivatePaste").change(function() {
      var bIsChecked = $(this).is(':checked');

      if (bIsChecked === true) {
        $("#PasswordInput").show();
        $("#ConfirmPassword").show();
      } else {
        $("#PasswordInput").hide();
        $("#ConfirmPassword").hide();
      }
    })

    $("#HighlightPaste").change(function() {
      var bIsChecked = $(this).is(':checked');

      if (bIsChecked === true) {
        $("#SyntaxInput").show();
      } else {
        $("#SyntaxInput").hide();
      }
    })

    $(document).ready(function() {
      $('input:checkbox').prop('checked', false);
    });
  </script>
</body>

</html>
