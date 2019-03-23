<?php
session_start();
require('class/eventi.class.php');
$post = new Eventi;
$bozza = !isset($_SESSION['id']) ? 'f' : null;
$lista = $post->postList(null,$bozza, null);
// $postRow = array_chunk($lista, 3);
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
                <span class="input-group-text" id="filterStat"><span><?php echo count($lista) ?></span> / <span><?php echo count($lista) ?></span></span>
              </div>
            </div>
          </div>
        </div>
        <div class='row post-row'>
          <div class="card-columns">
            <?php
            foreach ($lista as $p) {
              $tag = [];
              $tags = str_replace(array("{","}",'"'),'',$p['tag']);
              $tags = explode(",",$tags);
              foreach ($tags as $v) {array_push($tag,"<small class='bg-info rounded text-white p-1 mr-1 mb-1 filtro' data-filter='".$v."'>".$v."</small>");}
              echo "<article class='card rounded-0 animation postDiv'>";
              echo "<figure class='card-title post-banner mb-0' style='background-image:url(upload/copertine/".$p['copertina'].")'></figure>";
              echo "<section class='card-body'>";
              echo "<p class='post-title filtro' data-filter='".$p['titolo']."'>".$p['titolo']."</p>";
              echo "<div class='post-body text-muted filtro' data-filter='".strip_tags($p['testo'])."'>".$post->truncate(strip_tags($p['testo'],'<br><br/><strong><b><ol><ul><li>'), 300, array('ending' => ' [...]', 'exact' => false, 'html' => true));
              echo "<div class='d-block my-2'>".join('',$tag)."</div>";
              echo "</div>";
              echo "</section>";
              echo "</article>";
            }
            ?>
          </div>
        </div>
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
      $('.postDiv').hover(function(){ $(this).toggleClass("shadow"); });
      if (!RegExp.escape) { RegExp.escape = function (value) { return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&") }; }
      var $div = $('.postDiv')
      var $filtro = $div.find('.filtro');
      $('[name=filtraPost]').keyup(function () {
        var filter = this.value, regex;
        if (filter.length > 2) {
          regex = new RegExp(RegExp.escape(this.value), 'i')
          var $found = $filtro.filter(function () { return regex.test($(this).data('filter')) }).closest('.postDiv').show();
          $div.not($found).hide()
        } else {
          $div.show();
        }
        $("#filterStat").find('span').eq(0).text($(".postDiv:visible").length)
        $("[name=filterReset]").on('click', function(){$("[name=filtraPost]").val('').trigger('keyup');})
      });
    </script>
  </body>
</html>
