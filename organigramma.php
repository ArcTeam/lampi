<?php
session_start();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent{top:10% !important;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent h-75">
      <div class="container h-100 bg-white p-3">
        <div class="row">
          <div class="col">

          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script src="js/login.js" charset="utf-8"></script>
  </body>
</html>
