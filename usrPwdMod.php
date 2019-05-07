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
          <div class="form-row mb-3">
            <div class="col">
              <label for="oldpwd" class="">password attuale</label>
              <div class="input-group">
                <input type="password" class="form-control form-control-sm" id="oldpwd" name="oldpwd" placeholder="Inserisci la tua password" required>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="col">
              <label for="newpwd" class="">nuova password</label>
              <div class="input-group input-group-sm">
                <input type="password" class="form-control" id="newpwd" name="newpwd" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" placeholder="digita la nuova password" required>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary show-pwd tip"  data-placement='top' title="mostra password" data-input='newpwd' type="button"><i class="far fa-eye  form-control-feedback"></i></button>
                </div>
              </div>
              <small>la password deve contenere almeno 1 lettera maiuscola, 1 numero e deve essere lunga almeno 8 caratteri</small>
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="col">
              <label for="checknewpwd" class="">conferma la nuova password</label>
              <div class="input-group input-group-sm">
                <input type="password" class="form-control" id="checknewpwd" name="checknewpwd" placeholder="conferma la nuova password" required>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary show-pwd tip" data-placement='top' title="mostra password" data-input='checknewpwd' type="button"><i class="far fa-eye  form-control-feedback"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row mb-3">
            <div class="col-lg-4">
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm form-control" name="modificaBtn">modifica</button>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="text-center msg"></div>
            </div>
          </div>
        </form>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hideshowpassword/2.0.8/hideShowPassword.min.js" charset="utf-8"></script>
    <script type="text/javascript">
      form = $("form[name=usrDataModForm]");
      oop = {file:'utente.class.php',classe:'Utente',func:'changePwd'}
      $(".show-pwd").on('click',function(){
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        input = $(this).data('input')
        $("#"+input).togglePassword();
      })
      $("[name=modificaBtn]").on('click',function(e){
        isvalidate = form[0].checkValidity();
        oldpwd = $("[name=oldpwd]").val()
        checknewpwd = $("[name=checknewpwd]").val()
        newpwd = $("[name=newpwd]").val()
        if (isvalidate) {
          e.preventDefault();
          if(checknewpwd !== newpwd){
            $(".msg").addClass('alert alert-danger').text('le password non coincidono')
          }else {
            $(".msg").removeClass('alert alert-danger').text('')
            dati={"oldpwd":oldpwd,"newpwd":newpwd}
            $.ajax({
              url: connector,
              type: 'POST',
              dataType: 'json',
              data: {oop:oop, dati:dati}
            })
            .done(function(data) {
              // console.log(data);
              $(".msg").addClass('alert alert-'+data[0]).text(data[1]);
            })
            .fail(function(xhr, status, error) {
              $(".msg").addClass('alert alert-danger').text("errore: "+error);
            })


          }
        }
      })
    </script>
  </body>
</html>
