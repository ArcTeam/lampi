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
              <input type="search" class="form-control" name="searchPost" placeholder="cerca post" />
              <div class="input-group-append">
                <button type="button" name="searchBtn" class="btn btn-info"><i class='fas fa-search'></i></button>
                <button type="button" name="searchReset" class="btn btn-danger"><i class='fas fa-times'></i></button>
                <span class="input-group-text" id="searchPostRes">
                  <span></span> / <span></span>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class='row post-row'>
          <div class="card-columns"></div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>

    <div class="alert outPutMsgAlert" role="alert">
      <p id="outPutMsg" class="text-center"></p>
      <p id="countdowntimer" class="text-center"></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js" charset="utf-8"></script>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      // if (!RegExp.escape) { RegExp.escape = function (value) { return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&") }; }
      // var $div = $('.postDiv')
      // var $filtro = $div.find('.filtro');
      // $('[name=filtraPost]').keyup(function () {
      //   var filter = this.value, regex;
      //   if (filter.length > 2) {
      //     regex = new RegExp(RegExp.escape(this.value), 'i')
      //     var $found = $filtro.filter(function () { return regex.test($(this).data('filter')) }).closest('.postDiv').show();
      //     $div.not($found).hide()
      //   } else {
      //     $div.show();
      //   }
      //   $("#filterStat").find('span').eq(0).text($(".postDiv:visible").length)
      //   $("[name=filterReset]").on('click', function(){$("[name=filtraPost]").val('').trigger('keyup');})
      // });
      $("[name=searchPost]").keyup(function (e) {
        if (e.which == 13) { //key code del tasto invio
          $('[name=searchBtn]').trigger('click');
        }
      });
      $("[name=searchBtn]").on('click', function(){
        let keywords = $("[name=searchPost]").val()
        initPost(keywords, function(data){
          $("#searchPostRes").find('span').eq(0).text(data.length)
          buildPostView(data)
        })
        $("[name=searchReset]").show()
      })
      $("[name=searchReset]").hide().on('click',function(){
        $("[name=searchPost]").val('')
        $("[name=searchBtn]").trigger('click')
        $(this).hide()
      })
      initPost('', function(data){
        $("#searchPostRes").find('span').text(data.length)
        buildPostView(data)
      })
    </script>
  </body>
</html>
