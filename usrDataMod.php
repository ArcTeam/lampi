<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
require("class/utente.class.php");
$obj = new Utente;
$dati = $obj->utente();
$utente = $dati[0];
?>
<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      [name="rescuePwdForm"]{display:none;}
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
            <div class="col-md-4">
              <div class="form-group">
                <label for="cognome" class="">Cognome</label>
                <input type="text" class="form-control form-control-sm campo" id="cognome" name="cognome" placeholder="Cognome" value="<?php echo $utente['cognome']; ?>" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="nome" class="">Nome</label>
                <input type="text" class="form-control form-control-sm campo" id="nome" name="nome" placeholder="Nome" value="<?php echo $utente['nome']; ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email" class="">Email</label>
                <input type="email" class="form-control form-control-sm campo" id="email" name="email" placeholder="@Email" value="<?php echo $utente['email']; ?>" required>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="indirizzo" class="">Indirizzo</label>
                <input type="text" class="form-control form-control-sm campo" id="indirizzo" name="indirizzo" placeholder="Indirizzo" value="<?php echo $utente['indirizzo']; ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="cellulare" class="">Cellulare</label>
                <input type="text" class="form-control form-control-sm campo" id="cellulare" name="cellulare" placeholder="Cellulare" value="<?php echo $utente['cellulare']; ?>">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fisso" class="">Fisso</label>
                <input type="text" class="form-control form-control-sm campo" id="fisso" name="fisso" placeholder="Fisso" value="<?php echo $utente['fisso']; ?>">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="note" class="">Note</label>
                <textarea id="note" name="note" class="form-control form-control-sm campo" rows="5" placeholder="note" value="<?php echo $utente['note']; ?>"><?php echo nl2br($utente['note']); ?></textarea>
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
          <div class="form-row">
            <div class="col">
              <div class="msg"></div>
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
          dati = {};
          $(".campo").each(function(index, el) { dati[$(el).attr('name')]=$(el).val(); });
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {oop:{file:'utente.class.php',classe:'Utente',func:'changeUsrData'},dati:dati}
          })
          .done(function(data) {
            $('.msg').addClass('alert alert-success text-center').text('Ok, i dati sono stati correttamente modificati');
          })
          .fail(function(xhr, status, error) {
            $('.msg').addClass('alert alert-danger text-center').text('errore: '+error);
          })

        }
      })
    </script>
  </body>
</html>
