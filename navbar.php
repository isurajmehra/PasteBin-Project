<nav class="navbar shadow-sm fixed-top navbar-expand-lg text-light bg-dark">
  <a class="navbar-brand display-2" href="../index">
    <span style="color: pink;">21</span>Pastes - a paste dump project
  </a>

  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">

  </div>

  <?php
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {

    echo '
      <div class="dropdown show">
          <a class="btn btn-primary my-2 my-sm-0 p-2 pl-3 pr-3 ml-3 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Logged in : ' . $_SESSION["username"] . '</a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="../index">Post A Paste</a>
            <a class="dropdown-item" href="../private">Your Pastes</a>
            <a class="dropdown-item" href="../public">Public Pastes</a>
            <hr class="p-0 m-0">
            <a class="dropdown-item" href="auth/logout">Logout</a>
          </div>
      </div>';

} else {
    echo '
      <form class="form-inline my-2 my-lg-0" action="../login">
        <button class="btn btn-primary my-2 my-sm-0 p-2 pl-3 pr-3" type="submit">Login</button>
      </form>';
  }
  ?>
</nav>
