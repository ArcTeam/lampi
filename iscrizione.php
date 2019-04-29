<?php
session_start();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container{min-height:600px;}
      .ul{list-style-type: circle; margin-block-start: 1em; margin-block-end: 1em; margin-inline-start: 0px; margin-inline-end: 0px; padding-inline-start: 40px;}
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="p-3">
              <h3 class="text-center">Benvenuto nella pagina di iscrizione all'associazione culturale G.B.Lampi</h3 class="text-center">
              <hr class="my-3">
              <p>Iscriversi è facile, basta versare la quota sociale di:</p>
              <ul class="ul">
                <li>20&euro; come socio ordinario</li>
                <li>25&euro; come socio "sostenitore"</li>
              </ul>
              <p>sul seguente conto corrente bancario:</p>
              <p>Codice IBAN: <strong>IT75M0820034830000000043399</strong></p>
              <p>Intestato a: <strong>Associazione Cuturale G.B.Lampi</strong></p>

              <p>Una volta effettuato il versamento, puoi:</p>
              <ol>
                <li>inviare una mail all'indirizzo associazione.lampi@gmail.com con indicati nome, cognome, indirizzo postale, indirizzo e-mail e una copia del verrsamento effettuato</li>
                <li>compilare il seguente form</li>
              </ol>

              <p>Iscrivendoti all'associazione riceverai le pubblicazioni previste per l'anno di validità dell'iscrizione e la tessera socio (o il rinnovo della stessa) che dà diritto alle seguenti agevolazioni:</p>
              <ul class="ul">
                <li>Libreria “LA CATTEDRA” – via F. Filzi, 9 a CLES – sconto 10% sui libri (esclusi testi scolatici)</li>
                <li>Libreria “IL GABBIANO” – via V. Inama, 1 a FONDO – sconto 10% sui libri (spesa minima € 25 ed esclusi testi scolatici)</li>
                <li>Galleria d’Arte FEDRIZZI – piazza Granda a CLES – sconto 10% sui tappeti non cumulabile con altre offerte o sconti</li>
                <li>Monumenti e collezioni provinciali (Museo Buonconsiglio, Castelli Beseno-Stenico e Thun): ingresso a tariffa ridotta</li>
                <li>Museo MART di Rovereto: ingresso mostre a tariffa ridotta</li>
              </ul>
              <form class="form formStretto border" action="iscrizioneRes.php" method="post" enctype="multipart/form-data">
                <h5 class="p-3 bg-light border-bottom">Form di iscrizione<br>
                  <small>* campi obbligatori</small>
                </h5>
                <div class="form-group px-2 px-md-5">
                  <label for="nome">*Nome:</label>
                  <input type="text" id="nome" class="form-control" name="nome" value="" placeholder="Nome" required>
                </div>
                <div class="form-group px-2 px-md-5">
                  <label for="cognome">*Cognome:</label>
                  <input type="text" id="cognome" class="form-control" name="cognome" value="" placeholder="Cognome" required>
                </div>
                <div class="form-group px-2 px-md-5">
                  <label for="indirizzo">*Indirizzo:</label>
                  <input type="text" id="indirizzo" class="form-control" name="indirizzo" value="" placeholder="Indirizzo attuale" required>
                </div>
                <div class="form-group px-2 px-md-5">
                  <label for="telefono">*Telefono:</label>
                  <input type="text" id="telefono" class="form-control" name="telefono" value="" placeholder="Telefono (fisso o cellulare)" required>
                </div>
                <div class="form-group px-2 px-md-5">
                  <label for="email">*Email:</label>
                  <input type="email" id="email" class="form-control" name="email" value="" placeholder="Email" required>
                </div>
                <div class="form-group px-2 px-md-5">
                  <label for="versamento">Allega copia versamento:</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="versamento" id="versamento" lang="it">
                      <label class="custom-file-label" for="versamento" data-browse="carica file" lang="it">carica...</label>
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-secondary tip" data-placement="top" type="button" title="Attenzione: puoi caricare immagini(jpg,jpeg,png) o pdf di dimensioni non superiori ai 5MB."><i class="fas fa-info"></i></button>
                    </div>
                  </div>
                  <small>Puoi effettuare il versamento anche in un secondo momento e inviarlo via email all'indirizzo: associazione.lampi@gmail.com</small>
                </div>
                <div class="form-group px-2 px-md-5">
                  <p class="font-weight-bold">L'associazione culturale G.B.Lampi assicura che i dati trasmessi non saranno ceduti a terzi né resi pubblici senza il tuo consenso</p>
                  <p>Prima di inviare la tua richiesta di iscrizione leggi la nostra <a href="privacy.php" target="_blank" title="Informativa sulla privacy">informativa sulla privacy</a></p>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="privacy" value="1" required="">
                    <label class="form-check-label" for="privacy"><small>Ok! Ho letto l'<a href="privacy.php" class="" target="_blank" title="pagina in cui vengono descritti i termini di servizio dei dati condivisi">informativa sulla privacy</a></small></label>
                  </div>
                </div>
                <div class="form-group px-2 px-md-5">
                  <div class="button-group">
                    <button type="submit" class="btn btn-primary" id="submit">invia dati</button>
                    <a href="index.php" class="btn btn-outline-secondary" title="Annulla iscrizione e torna alla home page">annula iscrizione</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js" charset="utf-8"></script>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      $(".mainContent").css({"top" : $(".mainHeader").height() + 20})
    </script>
  </body>
</html>
