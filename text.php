<?php
session_start([
  'use_strict_mode' => 1,
  'use_only_cookies' => 1,
  'use_trans_sid' => 0,
  'cookie_lifetime' => 1800,
  'cookie_secure' => 1,
  'cookie_httponly' => 1
]);

include_once("auth/mysqli_wrapper.php");
include_once("auth/utils.php");

$Utils = new Utils();
$p = htmlspecialchars($_GET["p"]);

if (!$p) {
  $Utils->throwError("Paste not found!");
}

$author = false;
$uid = $_SESSION["UID"];

$connection = new mysqli_wrapper();
$query = $connection->query('SELECT * FROM `tbl_posts` WHERE `PID` = ? AND `UID` = ?', [$p, $uid]);

if ($query->num_rows !== 0) {
  $_SESSION["auth"] = true;
  $author = true;
}

$query = $connection->query('SELECT * FROM `tbl_pastes` WHERE `PID` = ?', [$p]);
if ($query->num_rows === 0) {
  $Utils->throwError("Paste not found!");
}

$result = $query->fetch_assoc();
$password = $result["password"];

if ($password !== "" && !isset($_SESSION["auth"])) {
  header("Location:../locked/" . $p);
}

unset($_SESSION["auth"]);

$expiry = $result["Expiry"];

if ($expiry != -1) {
  $expiry = $expiry - time();
  if ($expiry < 1) {
    $Utils->throwError("This post has expired!");
  } else {
    $expiry = "in " . $Utils->secToDaysHoursMinutes($expiry);
  }
} else {
  $expiry = "never";
}

if(isset($_POST["btnConfirmEdit"])) {
  $text = $_POST["PasteInput"];

  $text = htmlspecialchars($text);

  if ($text === "") {
    $Utils->throwError("Paste is blank!");
  }

  $Utils->Edit($text, $p);
  header("Location:../text/" . $p);
}

if(isset($_POST["btnConfirmDelete"])) {
  $Utils->Delete($p);
  header("Location:../index");
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/slate/bootstrap.min.css" integrity="sha384-8iuq0iaMHpnH2vSyvZMSIqQuUnQA7QM+f6srIdlgBrTSEyd//AWNMyEaSF2yPzNQ" crossorigin="anonymous">
  <title>21Pastes</title>

  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <script>hljs.highlightAll();</script>

  <style>
    .hiddenelem {
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
                <div class="text-xs font-weight-bold text-uppercase mb-1"><span style="color: green;">Success</span></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Here is your paste, copy the link to share! Click <a onclick="history.back();"><span style="color: pink;">Here</span></a> to go back</div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mt-3 box-shadow text-light" style="background-color: #1c1e22;">
          <div class="card-header" style="background-color: #1c1e22;">
            <h4 class="my-0 font-weight-normal"><span class="badge badge-pill badge-dark p-2 pl-3 pr-3" style="color: pink;"><?=strtoupper($result["syntax"]);?></span> <?=htmlspecialchars($result["title"])?></h4>
          </div>
          <div class="card-body overflow-auto p-2" id="messageBody" style="height: auto; max-height: auto; background-color: #1c1e22;">
            <form class="m-3">
              <div class="form-group">
                <pre contenteditable="false"><code class="<?=$result["syntax"]?>" id="formatPaste"><?=strip_tags($result["text"])?></code></pre>
              </div>
              <div class="row">
                <div class="col-6">
                  <label class="form-label" for="inlineCheckbox1">Expires <?=$expiry?></label>
                </div>
                <div class="col-6">
                  <label class="form-label" for="inlineCheckbox1">Size : <?= $Utils->sizeOfText($result["text"])?></label>
                </div>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rawPasteToggled" value="private">
                <label class="form-check-label" for="inlineCheckbox1">Editable</label>
              </div>
            </form>
            <?php
            if ($author === true || $_SESSION["username"] == "21Dogs") {
              echo '<button class="btn btn-primary mt-2 mb-2 w-25 btnEdit" name="edit" data-toggle="modal" data-target="#editModal" id="' . $result["PID"] . ' data-id="' . $result["PID"] . '">Edit</button>';
              echo '<button class="btn btn-primary mt-2 mb-2 w-25 btnDelete" name="delete" data-toggle="modal" data-target="#deleteModal" id="' . $result["PID"] . ' data-id="' . $result["PID"] . '">Delete</button>';
            }
            ?>

          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light">Edit "<?=$result["title"]?>"</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form class="m-3" method="POST" autocomplete="off">
                    <div class="form-group">
                      <textarea class="form-control" id="PasteInput" name="PasteInput" rows="15" placeholder="Paste Area"><?=$result["text"]?></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning mt-2 mb-2 w-100 btnConfirmEdit" name="btnConfirmEdit">Confirm Edit</button>
                  </form>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="deleteModal" role="dialog">
          <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title text-light">Delete Paste?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <form class="m-3" method="POST" autocomplete="off">
						<p class="text-light">You're finna delete '<?=$result["title"]?>', you sure?</p>
                      <button type="submit" class="btn btn-danger mt-2 mb-2 w-100 btnConfirmDelete" name="btnConfirmDelete">Confirm Delete</button>
                    </form>
                  </div>
              </div>

          </div>
      </div>

  <?php include("footer.php"); ?>

  <script>

  $(".btnEdit").click(function (e) {
    uid = $(this).attr('id');
    $('.btnConfirmEdit').attr('data-id', uid);
  });

  $(".btnDelete").click(function (e) {
    uid = $(this).attr('id');
    $('.btnConfirmDelete').attr('data-id', uid);
  });

  function setHeight(fieldId){
    document.getElementById(fieldId).style.height = document.getElementById(fieldId).scrollHeight+'px';
  }

    $("#rawPasteToggled").change(function() {
      var bIsChecked = $(this).is(':checked');
      var formattedPaste = document.getElementById("formatPaste");

      if (bIsChecked === true) {
        formattedPaste.setAttribute("contentEditable", true);
        //$("#rawPaste").show();
        //$("#formatPaste").hide();
        //setHeight('rawPaste');
        //<textarea class="form-control hiddenelem overflow-hidden" id="rawPaste" name="rawPasta" rows="8"></textarea>
      } else {
        formattedPaste.setAttribute("contentEditable", false);
      }
    })

    $(document).ready(function() {
      $('input:checkbox').prop('checked', false);
    });

  </script>
</body>

</html>
