<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
require('class/eventi.class.php');
$obj = new Eventi;
$res = $obj->handlePost($_POST,$_FILES);
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .container{min-height:600px;}
      #root{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 80vh;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
        overflow: auto;
      }
      #child{
        border: 1px solid #ddd;
        border-radius: .25rem;
        height:50vh;
        overflow: auto;
        padding: 20px;
        width: 80%;
        text-align: center;
      }
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div>
      <div id="root" class="bg-light">
        <div id="child" class="bg-white">
          <?php
          print_r($_FILES);
          echo "<hr>";
          foreach ($res as $key => $value) {
            echo $key." = ";
            if (is_array($value)) {
              foreach ($value as $v) { echo $v."<br>"; }
            }else {
              echo $value;
            }
            echo "<br>";
          }
          ?>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">

    </script>
  </body>
</html>
