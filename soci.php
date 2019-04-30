<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
// require('class/amministratore.class.php');
// $obj = new Amministratore;
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container-fluid{min-height:600px;}
      #listaSoci{min-height:200px;height:auto;max-height: 350px;overflow: auto;}
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
              <p>navbar</p>
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
              <div class="card-body">
                <select class="form-control" name="filtro">
                  <option value="">filtro</option>
                </select>
              </div>
              <ul class="list-group list-group-flush" id="listaSoci"></ul>
            </div>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
    $(".mainTitle").css({"margin-top" : $(".mainHeader").height()})
    $(".mainContent").css({"top" : $(".mainHeader").height() + $(".mainTitle").height() + 50})
    listaSoci('t')
    function listaSoci(filtro){
      list=[];
      option = {
        url: connector,
        type: 'POST',
        dataType: 'json',
        data: {
          oop:{file:'amministratore.class.php',classe:'Amministratore',func:'listaSoci'},
          dati:{filtro:filtro}
        }
      }
      $.ajax(option)
        .done(function(data){
          if (filtro == 't') {$("#listaSociHeader").text('soci attivi ('+data.length+')')}
          else if (filtro == 'f') {$("#listaSociHeader").text('soci non attivi ('+data.length+')')}
          else { $("#listaSociHeader").text('archivio soci completo ('+data.length+')') }
          $.each(data,function(i,v){ list.push("<li class='list-group-item'>"+v.socio+"</li>") })
          $("#listaSoci").html(list.join(''))
        })
        .fail(function(xhr, status, error) { $("#listaSoci").html(error); })
    }
    </script>
  </body>
</html>
