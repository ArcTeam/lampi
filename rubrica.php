<?php
session_start();
if (isset($_POST['submit'])) {
  if($_POST['submit']=='inserisci'){
    echo 'inserisci utente';
  }elseif ($_POST['submit']=='modifica') {
    echo 'modifica utente';
  }else {
    echo 'elimina utente';
  }
}
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent{top:6% !important;}
      .mainContent .container-fluid{min-height:600px;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="px-3 py-2 border-bottom">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#rubricaFormWrap" aria-expanded="false" aria-controls="rubricaFormWrap">aggiungi un nuovo utente</button>
      </div>
      <div class="container-fluid bg-white p-3">
          <div class="row collapse" id="rubricaFormWrap">
            <div class="col">
              <form name="rubricaForm">
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cognome" class="">Cognome</label>
                      <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nome" class="">Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email" class="">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="@Email">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="indirizzo" class="">Indirizzo</label>
                      <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="Indirizzo">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cellulare" class="">Cellulare</label>
                      <input type="text" class="form-control" id="cellulare" name="cellulare" placeholder="Cellulare">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="fisso" class="">Fisso</label>
                      <input type="text" class="form-control" id="fisso" name="fisso" placeholder="Fisso">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label for="note" class="">Note</label>
                      <textarea id="note" name="note" class="form-control" rows="5" placeholder="note"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary" id="submitRubrica">salva record</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <div class="row">
          <div class="col tableWrap">
            <p class="h4 d-none text-center">La rubrica è vuota</p>
            <table class="table table-sm d-none">
              <thead>
                <tr>
                  <th scope="col" class="all">cognome</th>
                  <th scope="col" class="all">nome</th>
                  <th scope="col" class="all">email</th>
                  <th scope="col" class="desktop">indirizzo</th>
                  <th scope="col" class="desktop">cellulare</th>
                  <th scope="col" class="desktop">fisso</th>
                  <th scope="col" class="none">note</th>
                  <th class="all"></th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot class="hide-if-no-paging"></tfoot>
            </table>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      buildTable('buildTable','rubrica',function( data ) {
        if (data.length==0) {
          $(".tableWrap>p").removeClass('d-none');
        }else {
          $(".tableWrap>table").removeClass('d-none');
        }
      })
    </script>
  </body>
</html>
