<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
require('class/eventi.class.php');
$obj = new Eventi;
if (isset($_POST['act']) && $_POST['act']=='mod') {
  unset($_POST['act']);
  $res = $obj->modifica($_POST,$_FILES);
}else {
  $res = $obj->nuovo($_POST,$_FILES);
}
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
            <h5 class="p-5">Ok, il record è stato salvato correttamente!</h5>
            <div class="mt-5">
              <a href="postView.php" data-id="<?php echo $res[1]; ?>" class="btn btn-success viewPost">visualizza record</a>
              <a href="postMod.php?r=<?php echo $res[1]; ?>" class="btn btn-success">modifica record</a>
              <a href="postAct.php?act=<?php echo $_POST['act']; ?>&tipo=<?php echo $_POST['tipo']; ?>" class="btn btn-success">crea nuovo</a>
              <a href="index.php" class="btn btn-success">torna alla home</a>
            </div>
          <?php }else{
            print_r($res);
          };?>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
  </body>
  <script type="text/javascript">
    $(".viewPost").on('click', function() {sessionStorage.setItem('post',$(this).data('id'))});
  </script>
</html>
