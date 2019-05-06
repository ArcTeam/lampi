<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
require('class/amministratore.class.php');
$obj = new Amministratore;
$anniQuote = $obj->anniQuote();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container-fluid{min-height:600px;}
      .listeWrap{min-height:200px;height:auto;max-height: 350px;overflow: auto;font-size:.9rem;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainTitle bg-white  border-bottom py-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <h2>Gestione soci</h2>
          </div>
          <div class="col-md-6">
            <div class="float-right">
              <p></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mainContent">
      <div class="container-fluid bg-white p-3">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header"><h5 id="listaSociHeader"></h5></div>
              <div class="card-body p-2">
                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="btn-group btn-group-sm btn-group-toggle mb-3" data-toggle="buttons">
                    <label class="btn btn-outline-secondary active">
                      <input type="radio" name="filtro" id="filtroAct" value="t" autocomplete="off" checked> attivi
                    </label>
                    <label class="btn btn-outline-secondary">
                      <input type="radio" name="filtro" id="filtroNoAct" value="f" autocomplete="off"> non attivi
                    </label>
                    <label class="btn btn-outline-secondary">
                      <input type="radio" name="filtro" id="filtroNull" value="" autocomplete="off"> lista completa
                    </label>
                  </div>
                  <div class="input-group input-group-sm">
                    <input type="search" name="cercaSocio" class="form-control" style="width:100px;" placeholder="cerca socio..." value="">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-secondary" name="clearFilter">
                        <i class='fas fa-times'></i>
                      </button>
                    </div>
                  </div>
                </div>
                <ul class="list-group list-group-flush listeWrap" id="listaSoci"></ul>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header"><h5 id="quoteHeader">Quote mancanti, anno <span id="annoQuota"><?php echo date('Y'); ?></span></h5></div>
              <div class="card-body p-2">
                <div class="btn-toolbar justify-content-end" role="toolbar" aria-label="Toolbar with button groups">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class='input-group-text'>controlla anno</span>
                    </div>
                    <select class="form-control w-auto mb-3" name="annoQuota">
                      <?php
                      for ($i=date('Y'); $i >= $anniQuote[0]['anno']; $i--) { echo "<option value='".$i."'>".$i."</option>"; }
                      ?>
                    </select>
                  </div>
                </div>
                <ul class="list-group list-group-flush listeWrap" id="checkQuote"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
    anno = new Date().getFullYear();
    listaSoci('t')
    checkQuote(anno)
    $(".mainTitle").css({"margin-top" : $(".mainHeader").height()})
    $(".mainContent").css({"top" : $(".mainHeader").height() + $(".mainTitle").height() + 50})
    $("[name=filtro]").on('change', function(){listaSoci($(this).val())})
    $("[name=clearFilter]").on('click', function(){ $("[name=cercaSocio]").val('').trigger('click') })

    $("[name=cercaSocio]").on("keyup click input", function () {
      if (this.value.length > 0) {
        $("#listaSoci li").removeClass("match").hide().filter(function () {
          return $(this).text().toLowerCase().indexOf($("[name=cercaSocio]").val().toLowerCase()) != -1;
        }).addClass("match").show();
        highlight(this.value);
        $("#listaSoci").show();
      } else {
        $("#listaSoci, #listaSoci li").removeClass("match");
        $("#listaSoci, #listaSoci li").show();
        $("#listaSoci li").removeClass("match").hide().filter(function () {
          return $(this).text().toLowerCase().indexOf($("[name=cercaSocio]").val().toLowerCase()) != -1;
        }).addClass("match").show();
        highlight(this.value);
      }
    });

    $("[name=annoQuota]").on('change',function(){
      $("#annoQuota").text($(this).val())
      checkQuote($(this).val())
    })

    $('body').on('click', '[name=quotaOk]', function(e) {
      let socioid = $(this).data('socioid')
      let socio = $(this).data('socio')
      let quota = $(this).data('anno')
      let msg = "Stai registrando la quota per l'anno "+quota+" di "+socio+" come regolarmente pagata"
      if (confirm(msg)) {
        option = {url: connector,type: 'POST', dataType: 'json', data: { oop:{file:'amministratore.class.php',classe:'Amministratore',func:'registraQuota'}, dati:{socio:socioid,tipo:2,anno:quota}}}
        $.ajax(option)
          .done(function(data){ checkQuote(anno)})
          .fail(function(xhr, status, error) { alert(error); })
      }
    });

    function highlight (string) {
      $("#listaSoci li.match").each(function () {
        var matchStart = $(this).text().toLowerCase().indexOf("" + string.toLowerCase() + "");
        var matchEnd = matchStart + string.length - 1;
        var beforeMatch = $(this).text().slice(0, matchStart);
        var matchText = $(this).text().slice(matchStart, matchEnd + 1);
        var afterMatch = $(this).text().slice(matchEnd + 1);
        $(this).html(beforeMatch + "<strong>" + matchText + "</strong>" + afterMatch);
      });
    };

    function listaSoci(filtro){
      let list=[];
      option = { url: connector, type: 'POST', dataType: 'json', data: { oop:{file:'amministratore.class.php',classe:'Amministratore',func:'listaSoci'}, dati:{filtro:filtro}}}
      $.ajax(option)
        .done(function(data){
          if (filtro == 't') {$("#listaSociHeader").text('soci attivi ('+data.length+')')}
          else if (filtro == 'f') {$("#listaSociHeader").text('soci non attivi ('+data.length+')')}
          else { $("#listaSociHeader").text('archivio soci completo ('+data.length+')') }
          $.each(data,function(i,v){ list.push("<li class='list-group-item'>"+v.socio+" <a href='schedaSocio.php' class='btn btn-sm btn-outline-info float-right' title='apri scheda socio'><i class='fas fa-link'></i></a></li>") })
          $("#listaSoci").html(list.join(''))
        })
        .fail(function(xhr, status, error) { $("#listaSoci").html(error); })
    }

    function checkQuote(anno){
      let list=[];
      option = {url: connector,type: 'POST', dataType: 'json', data: { oop:{file:'amministratore.class.php',classe:'Amministratore',func:'checkQuote'}, dati:{anno:anno}}}
      $.ajax(option)
        .done(function(data){
          if (data.length > 0) {
            $.each(data,function(i,v){
              list.push("<li class='list-group-item'>"+v.socio+" <button type='button' class='btn btn-sm btn-outline-success float-right' data-anno='"+anno+"' data-socioid='"+v.idsocio+"' data-socio='"+v.socio+"' name='quotaOk' title='registra quota'><i class='fas fa-check'></i></button></li>")
            })
            $("#checkQuote").html(list.join(''))
          }else {
            $("#checkQuote").html("<li class='list-group-item'>ottimo, tutte le quote del "+anno+" risultano pagate!</li>")
          }

        })
        .fail(function(xhr, status, error) { $("#checkQuote").html(error); })
    }
    </script>
  </body>
</html>
