<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
require('class/utente.class.php');
$obj = new Utente;
$iscrizioni = $obj->iscrizioniList();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container-fluid{min-height:600px;}
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainTitle bg-white  border-bottom py-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <h2>Richieste di iscrizione</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="mainContent">
      <div class="container-fluid">
          <div class="card-columns iscrizioniWrap">
            <?php foreach ($iscrizioni as $richiesta) { ?>
            <div class="card shadow">
              <div class="card-header">
                <h5><?php echo $richiesta['cognome']." ".$richiesta['nome']; ?></h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fas fa-at fa-fw"></i> <?php echo $richiesta['email']; ?></li>
                <li class="list-group-item"><i class="fas fa-phone fa-fw"></i> <?php echo $richiesta['telefono']; ?></li>
                <li class="list-group-item"><i class="fas fa-map-marker-alt fa-fw"></i> <?php echo $richiesta['indirizzo']; ?></li>
                <li class="list-group-item"><i class="fas fa-paperclip fa-fw"></i>
                <?php if ($richiesta['versamento']) {
                  echo "<a href='upload/versamenti/".$richiesta['versamento']."' target='_blank' title='visualizza versamento'>".substr($richiesta['versamento'],15)."</a>";
                }else {
                  echo "<span class='text-danger'>manca il versamento</span>";
                } ?>

                </li>
              </ul>
              <div class="card-body">
                <p class="card-text"><small class="text-muted">Richiesta effettuata il <?php echo explode(" ",$richiesta['data'])[0] ?></small></p>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-sm btn-primary" name="conferma" value="<?php echo $richiesta['id']; ?>">accetta richiesta</button>
              </div>
            </div>
            <?php } ?>
          </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js" charset="utf-8"></script>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
    $(".mainTitle").css({"margin-top" : $(".mainHeader").height()})
    $(".mainContent").css({"top" : $(".mainHeader").height() + $(".mainTitle").height() + 50})
    $("[name=conferma]").on('click', function(){
      msg = "confermando la richiesta di iscrizione l'utente verrà inserito nella lista dei soci attivi.";
      spinner = $("<i/>",{class:'fas fa-spinner fa-spin ml-3'});
      if (confirm(msg)) {
        $(this).closest('.card-footer').append(spinner)
        $.ajax({
          url: connector,
          type: 'POST',
          dataType: 'json',
          data: {
            oop: {file:'utente.class.php',classe:'Utente',func:'nuovoSocio'},
            dati:{id:$(this).val()}
          }
        }).done(function(data){
          spinner.remove()
          alert("ok, richiesta accettata\nl'utente è stato aggiunto alla lista dei soci attivi.");
          location.reload();
        }).fail(function(xhr, status, error) {
          alert("errore: "+error);
        })
      }
    })
    </script>
  </body>
</html>
