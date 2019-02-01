<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      [name="rescuePwdForm"]{display:none;}
    </style>
  </head>
  <body>
    <?php require('inc/header.php'); ?>
    <div class="mainContent">
      <div class="container bg-white p-3 border rounded">
        <form class="form formStretto" name="loginForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="username">email</label>
                <input type="email" id="email" name="email" class="form-control" value="" required>
              </div>
              <div class="form-group">
                <label for="pwd">password</label>
                <input type="password" id="pwd" name="pwd" class="form-control" value="" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm form-control" name="loginBtn">entra</button>
              </div>
            </div>
            <div class="col-lg-4 offset-lg-4">
              <div class="form-group">
                <button type="button" class="btn btn-outline-danger btn-sm form-control" name="toggleRescueForm">password dimenticata</button>
              </div>
            </div>
          </div>
          <div class="output text-center alert d-none">
            <div class="outMsg"></div>
            <div id="countdowntimer"></div>
          </div>
        </form>
        <br>
        <form class="form formStretto" name="rescuePwdForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="rescuePwdInput">Inserisci la mail fornita al momento dell'iscrizione, il server ti invierà una nuova password.</label>
                <input type="email" id="rescuePwdInput" name="rescueEmail" class="form-control" value="">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm form-control" name="rescuePwdBtn">genera password</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php require('inc/footer.php'); ?>
    <?php require('inc/lib.php'); ?>
    <script src="js/login.js" charset="utf-8"></script>
  </body>
</html>
