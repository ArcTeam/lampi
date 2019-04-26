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
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="container-fluid bg-white p-3">
        <div class="row">
          <div class="col-12">
            <div class="post-banner"></div>
            <div class="text-center my-3 pb-1 border-bottom border-info"><h1 class="text-info post-titolo"></h1></div>
          </div>
        </div>
        <div class="row dati">
          <div class="col-lg-8">

          </div>
          <div class="col-lg-4">

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
