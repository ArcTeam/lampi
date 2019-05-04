<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
?>
<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent{top:10% !important;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent h-75">
      <div class="container h-100 bg-white p-3">
        <form class="form formStretto" name="usrDataModForm">
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="oldpwd" class="">password attuale</label>
                <input type="password" class="form-control form-control-sm" id="oldpwd" name="oldpwd" placeholder="Inserisci la tua password" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="newpwd" class="">nuova password</label>
                <input type="password" class="form-control form-control-sm" id="newpwd" name="newpwd" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" placeholder="digita la nuova password" required>
                <small>la password deve contenere almeno 1 lettera maiuscola, 1 numero e deve essere lunga almeno 8 caratteri</small>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="checknewpwd" class="">conferma la nuova password</label>
                <input type="password" class="form-control form-control-sm" id="checknewpwd" name="checknewpwd" placeholder="conferma la nuova password" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-lg-4">
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm form-control" name="modificaBtn">modifica</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      form = $("form[name=usrDataModForm]");
      $("[name=modificaBtn]").on('click',function(e){
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault();
          if($("[name=checknewpwd]").val() !== $("[name=newpwd]").val()){
            alert('le password non coincidono')
          }else {
            alert($("[name=newpwd]").val())
          }
        }
      })
    </script>
  </body>
</html>
