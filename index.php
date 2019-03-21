<?php
session_start();
require("class/function.php");
require("class/global.class.php");
$bannerBg = randomBg();
$idx = new Generica;
$eventi = $idx->index();
?>
<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="bannerWrap position-fixed bg-white lozad" data-background-image="img/background/<?php echo $bannerBg; ?>">
      <div class="bannerTitle">
        <h1>Associazione culturale G.B.Lampi</h1>
      </div>
    </div>
    <div class="mainContent home bg-white">
      <div class="manifest shadow">
        <div class="container">
          <div class="row">
            <div class="col-md-4 manifestLogo"></div>
            <div class="col-md-8 py-3">
              <p>L'<strong>Associazione Culturale "G. B. Lampi"</strong> promuove lo studio e la divulgazione della cultura locale nel territorio dell'Alta Val di Non e della c.d. "Terza Sponda" in Trentino.<br>Fondata nel 1992, da vent'anni si dedica all'organizzazione di conferenze, serate culturali, convegni e alla pubblicazioni di volumi inerenti la storia, l'archeologia, la storia dell'arte e, più in generale, le manifestazioni culturali della gente d'Anaunia.</p>
              <p class="h4 border-bottom border-dark">DIVENTA SOCIO DELLA LAMPI!</p>
              <p>Iscriversi all'Associazione è semplice!<br>Scopri i vantaggi e le modalità d'iscrizione</p>
              <a href="iscrizione.php" class="btn btn-primary">diventa socio</a>
            </div>
          </div>
        </div>
      </div>
      <div class="cardWrap mt-5">
        <div class="container">
          <div id="eventi" class="mb-3">
            <div class="row">
              <div class="col">
                <h3 class="border-bottom">Eventi</h3>
              </div>
            </div>
            <div class="row eventiCardWrap"></div>
          </div>
          <div id="viaggi" class="mb-3">
            <div class="row">
              <div class="col">
                <h3 class="border-bottom">Viaggi</h3>
              </div>
            </div>
            <div class="row viaggiCardWrap"></div>
          </div>
          <div id="notizie" class="mb-3">
            <div class="row">
              <div class="col">
                <h3 class="border-bottom">Notizie</h3>
              </div>
            </div>
            <div class="row notizieCardWrap"></div>
          </div>
          <div id="foto" class="mb-3">
            <div class="row">
              <div class="col">
                <h3 class="border-bottom">Immagini</h3>
              </div>
            </div>
            <div class="row fotoCardWrap"></div>
          </div>
          <div id="tag" class="mb-3">
            <div class="row">
              <div class="col">
                <h3 class="border-bottom">Parole</h3>
              </div>
            </div>
            <div class="row tagCardWrap"></div>
          </div>

        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
  </body>
</html>
