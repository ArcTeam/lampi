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
      .metadati ul{font-size:14px}
      #lista-meta>li{padding-left:0;}
      #lista-meta>li>*{vertical-align: top;}
      #lista-meta>li>span:last-child{font-weight:bold;display:inline-block;width:calc(100% - 130px);}
      #lista-meta>li>span:nth-child(2){display:inline-block;width:100px;}
      #lista-meta>li>i{display:inline-block;width:30px;color:#28a745;padding-top:5px;}
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="post-banner"></div>
            <div class="text-center my-3 pb-1 border-bottom border-info text-shadow"><h1 class="text-info post-titolo"></h1></div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row dati">
          <div class="col-lg-8 border-right">
            <div id="testo"></div>
          </div>
          <div class="col-lg-4 metadati">
            <p class="h5 border-bottom font-weight-bold altre-info">Info <span></span></p>
            <div id="info-div"><p class='text-center my-2'>Nessuna informazione aggiuntiva presente</p></div>
            <p class="mt-3 h5 border-bottom font-weight-bold altre-info">Allegati</p>
            <div id="allegati-div"><p class='text-center my-2'>Nessun allegato presente</p></div>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js" charset="utf-8"></script>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      let id = sessionStorage.getItem('post')
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      post(id)
    </script>
  </body>
</html>
