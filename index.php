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
        <div class="container-fluid">
          <div class="row"><div class="col"><h1 class="border-bottom">Post</h1></div></div>
          <div class="row mb-3"><div class="col"><div class="card-columns postCardWrap"></div></div></div>
          <div class="row"><div class="col"><h1 class="border-bottom">Eventi</h1></div></div>
          <div class="row mb-3"><div class="col"><div class="card-columns eventiCardWrap"></div></div></div>
          <div class="row"><div class="col"><h1 class="border-bottom">Viaggi</h1></div></div>
          <div class="row mb-3"><div class="col"><div class="card-columns viaggiCardWrap"></div></div></div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js" charset="utf-8"></script>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      if(sessionStorage.length > 0){sessionStorage.clear()}
      initPost('',4,'',function(data){
        if(data.length>0){
          let arr = _.groupBy(data, function(arr) { return arr.tipo})
          buildPostView(arr['p'],'.postCardWrap')
          buildPostView(arr['e'],'.eventiCardWrap')
          buildPostView(arr['v'],'.viaggiCardWrap')
        }
      })
    </script>
  </body>
</html>
