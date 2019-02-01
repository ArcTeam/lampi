<?php
session_start();
?>
<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
  </head>
  <body>
    <?php require('inc/header.php'); ?>
    <div class="bannerWrap position-fixed bg-white"></div>
    <div class="mainContent home bg-white">
      <div class="manifest shadow">
        <div class="container">
          <div class="row">
            <div class="col-md-4 manifestLogo">
              <!-- <img src="img/busto_lampi.png" class="img-fluid m-auto" alt="busto Giovan Battista Lampi"> -->
            </div>
            <div class="col-md-8 py-3">
              <p>L'<strong>Associazione Culturale "G. B. Lampi" - Alta Anaunia</strong> promuove lo studio e la divulgazione della cultura locale nel territorio dell'Alta Val di Non e della c.d. "Terza Sponda" in Trentino.<br>Fondata nel 1992, da vent'anni si dedica all'organizzazione di conferenze, serate culturali, convegni e alla pubblicazioni di volumi inerenti la storia, l'archeologia, la storia dell'arte e, più in generale, le manifestazioni culturali della gente d'Anaunia.</p>
              <p class="h4 border-bottom border-dark">DIVENTA SOCIO DELLA LAMPI!</p>
              <p>Iscriversi all'Associazione è semplice!<br>Scopri i vantaggi e le modalità d'iscrizione</p>
              <a href="iscrizione.php" class="btn btn-primary">diventa socio</a>
            </div>
          </div>
        </div>
      </div>
      <div class="cardWrap mt-5">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 col-lg-4 mb-2 news">
              <div class="card">
                <div class="card-header"> <h5>News</h5> </div>
                <div class="card-body">

                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2 incontri">
              <div class="card">
                <div class="card-header"> <h5>Incontri</h5> </div>
                <div class="card-body">

                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-2 incontri">
              <div class="card">
                <div class="card-header"> <h5>Viaggi</h5> </div>
                <div class="card-body">

                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 imgGallery">
              <h5 class="border-bottom">Foto</h5>
            </div>
            <div class="col-md-6 tagCloud">
              <h5 class="border-bottom text-right">Parole</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require('inc/footer.php'); ?>
    <?php require('inc/lib.php'); ?>
  </body>
</html>
