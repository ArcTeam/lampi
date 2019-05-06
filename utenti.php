<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
require('class/amministratore.class.php');
$obj = new Amministratore;
$utenti = $obj->utenti();
$addUserList = $obj->addUserList();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container-fluid{min-height:600px;}
      .dati > * {display:inline-block;vertical-align:top;}
      .dati > i {width:20px; text-align:left;padding-top:5px;}
      .dati > span {width:calc(100% - 25px); text-align:left;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainTitle bg-white  border-bottom py-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <h2>Utenti di sistema</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="mainContent">
      <div class="container-fluid bg-white p-3">
        <div class="row">
          <div class="col-12">
            <div class="card-columns">
              <div class="card">
                <div class="card-header text-white bg-info">
                  <h5>Aggiungi utente di sistema</h5>
                </div>
                <div class="card-body">
                  <small class="d-block mb-3">Per aggiungere un nuovo utente selezionare un nominativo dalla lista e scegliere la classe di utente. Se l'utente non è presente nella lista devi prima aggiungerlo in rubrica.</small>
                  <form class="form" name="addUserForm">
                    <div class="form-group mb-3">
                      <select class="form-control form-control-sm" name="utente" required>
                        <option value="" selected>-- seleziona utente --</option>
                        <?php foreach ($addUserList as $item) {
                          echo "<option value='".$item['id']."'>".$item['utente']."</option>";
                        } ?>
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <select class="form-control form-control-sm" name="classe" required>
                        <option value="" selected>-- seleziona classe --</option>
                        <option value="1">utente semplice</option>
                        <option value="2">amministratore</option>
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <button type="submit" class="w-100 btn btn-sm btn-primary" id="addUserBtn">aggiungi utente</button>
                    </div>
                  </form>
                </div>
              </div>
              <?php foreach ($utenti as $utente) { ?>
              <div class="card">
                <div class="card-header">
                  <h5><?php echo $utente['cognome']." ".$utente['nome']; ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item font-weight-bold">Dati principali</li>
                  <li class="list-group-item dati">
                    <i class="fas fa-at fa-fw"></i>
                    <span><?php echo $utente['email']; ?></span>
                  </li>
                  <li class="list-group-item dati">
                    <i class="fas fa-map-marker-alt fa-fw"></i>
                    <span><?php echo $utente['indirizzo'] ? $utente['indirizzo'] : 'indirizzo non specificato'; ?></span>
                  </li>
                  <li class="list-group-item dati">
                    <i class="fas fa-mobile-alt fa-fw"></i>
                    <span><?php echo $utente['cellulare'] ? $utente['cellulare'] : 'cellulare non inserito'; ?></span>
                  </li>
                  <li class="list-group-item dati">
                    <i class="fas fa-phone-volume fa-fw"></i>
                    <span><?php echo $utente['fisso'] ? $utente['fisso'] : 'telefono fisso non specificato'; ?></span>
                  </li>
                  <li class="list-group-item dati">
                    <i class="fas fa-sticky-note fa-fw"></i>
                    <span><?php echo $utente['note'] ? nl2br($utente['note']) : 'nessuna nota inserita'; ?></span>
                  </li>
                  <li class="list-group-item font-weight-bold">Info account</li>
                  <li class="list-group-item">
                    <?php
                    if ($utente['classe']===1) {
                      echo "<span class='d-inline-block mb-3'>Classe: <span class='font-weight-bold'>utente semplice</span></span><button type='button' class='btn btn-sm btn-info float-right' name='promuovi'>promuovi ad ammnistratore</button>";
                    }else {
                      echo "<span class='d-inline-block mb-3'>Classe: <span class='font-weight-bold'>amministratore</span></span>";
                    }
                    ?>
                  </li>
                  <li class="list-group-item">
                    <?php
                    if ($utente['attivo']==='t') {
                      echo "<span class='d-inline-block mb-3'>Stato: <span class='font-weight-bold'>utente attivo</span></span>";
                      if ($utente['classe']===1) {
                        echo "<button type='button' class='btn btn-sm btn-info float-right' name='stato' value='f'>disattiva login</button>";
                      }
                    }else {
                      echo "<span class='d-inline-block mb-3'>Stato: <span class='font-weight-bold'>login disabilitato</span></span>";
                      if ($utente['classe']===1) {
                        echo "<button type='button' class='btn btn-sm btn-info float-right' name='stato' value='t'>riattiva login</button>";
                      }
                    }
                    ?>
                  </li>
                </ul>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
    $(".mainTitle").css({"margin-top" : $(".mainHeader").height()})
    $(".mainContent").css({"top" : $(".mainHeader").height() + $(".mainTitle").height() + 50})
    form = $("form[name=addUserForm]");
    $("#addUserBtn").on('click', function(e){
      isvalidate = form[0].checkValidity();
      if (isvalidate) {
        e.preventDefault();
        dati={}
        dati['utente'] = $("[name=utente]").val();
        dati['classe'] = $("[name=classe]").val();
      }
    })
    </script>
  </body>
</html>
