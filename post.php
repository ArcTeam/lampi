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
        <div class="row border-bottom mb-3">
          <div class="col-12 col-lg-8">
            <h3 class='text-muted titolo'></h3>
          </div>
          <div class="col-12 col-lg-4">
            <div class="btn-toolbar mb-3 float-right" role="toolbar" aria-label="Toolbar with button groups">
              <?php if(isset($_SESSION['id'])){ ?>
              <div class="btn-group btn-group-sm mr-3">
                <a href="" class="btn btn-primary btn-sm crea"></a>
              </div>
              <?php } ?>
              <div class="input-group input-group-sm">
                <input type="search" class="form-control" name="searchPost" placeholder="cerca..." />
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
        </div>
        <div class='row post-row'>
          <div class="col">
            <div class="card-columns"></div>
          </div>
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
      let tipo = localStorage.getItem('t')
      switch (tipo) {
        case 'p':
        $(".crea").attr('href','postAct.php?act=add&tipo=p').text('crea post')
        $(".titolo").text('Archivio post')
        break;
        case 'e':
        $(".crea").attr('href','postAct.php?act=add&tipo=e').text('crea evento')
        $(".titolo").text('Archivio eventi')
        break;
        case 'v':
        $(".crea").attr('href','postAct.php?act=add&tipo=p').text('crea viaggio')
        $(".titolo").text('Archivio viaggi')
        break;
      }
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      $("[name=searchPost]").keyup(function (e) {
        //key code del tasto invio
        if (e.which == 13) { $('[name=searchBtn]').trigger('click'); }
      });
      $("[name=searchBtn]").on('click', function(){
        let keywords = $("[name=searchPost]").val()
        initPost(keywords,'',tipo, function(data){
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
      initPost('','',tipo, function(data){
        $("#searchPostRes").find('span').text(data.length)
        buildPostView(data)
      })
    </script>
  </body>
</html>
