<?php
session_start();
require('class/utente.class.php');
$obj = new Utente;
$res = $obj->iscrizione($_POST,$_FILES['versamento']);
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .container{min-height:600px;}
      #root{display: flex; align-items: center;justify-content: center; height: 80vh; width: 100%; margin: 0 auto; padding: 20px; overflow: auto;}
      #child{border: 1px solid #ddd; border-radius: .25rem; height:50vh; overflow: auto; padding: 20px; width: 80%; text-align: center;}
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div>
      <div id="root" class="bg-light">
        <div id="child" class="bg-white">
          <?php if($res[0]===true){?>
            <h5 class="p-5">Ok, la tua richiesta è stata correttamente registrata!</h5>
          <?php }else{
            print_r($res);
          };?>
          <div class="mt-5">
            <a href="index.php" class="btn btn-success">torna alla home</a>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
  </body>
  <script type="text/javascript"></script>
</html>
