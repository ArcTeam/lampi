<?php
session_start();
require('class/eventi.class.php');
$post = new Eventi;
$bozza = !isset($_SESSION['id']) ? 'f' : null;
$lista = $post->postList(null,$bozza, null);
$postRow = array_chunk($lista, 3);
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
      <?php if(isset($_SESSION['id'])){ ?>
      <div class="px-3 py-2 border-bottom">
        <a href="postAct.php?act=add&tab=post" class="btn btn-primary btn-sm" >crea post</a>
      </div>
      <?php } ?>
      <div class="container bg-white p-3">
        <div class="row">
          <div class="col-12 col-lg-8">
            <h3 class='text-muted'>Archivio post</h3>
          </div>
          <div class="col-12 col-lg-4">
            <div class="input-group input-group-sm">
              <input type="search" class="form-control" name="filtraPost" placeholder="filtra post" />
              <div class="input-group-append">
                <button type="button" name="filterReset" class="btn btn-secondary"><i class='fas fa-times'></i></button>
                <span class="input-group-text" id="groupStat">xx/yy</span>
              </div>
            </div>
          </div>
        </div>
        <?php
        foreach ($postRow as $value) {
          echo "<div class='row post-row'>";
          foreach ($value as $p) {
            echo "<div class='col-md-4'>";
              echo "<article class='card rounded-0 animation'>";
                echo "<figure class='card-title post-banner lozad mb-0' data-background-image='upload/copertine/".$p['copertina']."'></figure>";
                echo '<section class="card-body">';
                  echo "<p class='post-title'>".$p['titolo']."</p>";
                  echo "<div class='post-body text-muted'>".$post->truncate(strip_tags($p['testo'],'<br><br/><strong><b><ol><ul><li>'), 300, array('ending' => ' [...]', 'exact' => false, 'html' => true))."</div>";
                echo '</section>';
              echo "</article>";
            echo "</div>";
          }
          echo "</div>";
        }
        ?>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>

    <div class="alert outPutMsgAlert" role="alert">
      <p id="outPutMsg" class="text-center"></p>
      <p id="countdowntimer" class="text-center"></p>
    </div>

    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      $("[name=filtraPost]").on('change',function(){
        console.log($(this).val());
      });
    </script>
  </body>
</html>
