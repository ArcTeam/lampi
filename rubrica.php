<?php
session_start();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent{top:6% !important;}
      .mainContent .container-fluid{min-height:600px;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="px-3 py-2 border-bottom">
        <button type="button" class="btn btn-primary btn-sm toggleForm" ><i class="fas fa-angle-down"></i> aggiungi un nuovo utente</button>
      </div>
      <div class="container-fluid bg-white p-3">
          <div class="row collapse" id="rubricaFormWrap">
            <div class="col">
              <form name="rubricaForm">
                <input type="hidden" class="campo" name="id" value="">
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cognome" class="">Cognome</label>
                      <input type="text" class="form-control campo" id="cognome" name="cognome" placeholder="Cognome" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nome" class="">Nome</label>
                      <input type="text" class="form-control campo" id="nome" name="nome" placeholder="Nome">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email" class="">Email</label>
                      <input type="email" class="form-control campo" id="email" name="email" placeholder="@Email">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="indirizzo" class="">Indirizzo</label>
                      <input type="text" class="form-control campo" id="indirizzo" name="indirizzo" placeholder="Indirizzo">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="cellulare" class="">Cellulare</label>
                      <input type="text" class="form-control campo" id="cellulare" name="cellulare" placeholder="Cellulare">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fisso" class="">Fisso</label>
                      <input type="text" class="form-control campo" id="fisso" name="fisso" placeholder="Fisso">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label for="note" class="">Note</label>
                      <textarea id="note" name="note" class="form-control campo" rows="5" placeholder="note"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary submitBtn"></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <div class="row">
          <div class="col tableWrap">
            <p class="h4 d-none text-center">La rubrica è vuota</p>
            <table class="table table-sm d-none">
              <thead>
                <tr>
                  <th scope="col" class="all">cognome</th>
                  <th scope="col" class="all">nome</th>
                  <th scope="col" class="all">email</th>
                  <th scope="col" class="desktop">indirizzo</th>
                  <th scope="col" class="desktop">cellulare</th>
                  <th scope="col" class="desktop">fisso</th>
                  <th scope="col" class="none">note</th>
                  <th class="all"></th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot class="hide-if-no-paging"></tfoot>
            </table>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      form = $("form[name=rubricaForm]");
      buildTable('buildTable','rubrica',function( data ) {
        if (data.length==0) {
          $(".tableWrap>p").removeClass('d-none');
        }else {
          console.log(data);
          data.forEach(function(v,i){
            btn=$("<button/>",{type:'button',class:'btn btn-outline-info btn-sm'})
            .html("<i class='fas fa-pencil-alt'></i>")
            .on('click',function(){
              if ($('#rubricaFormWrap').is(':hidden')) {
                $('.toggleForm').find('i').toggleClass('fa-angle-down fa-angle-up')
                $("#rubricaFormWrap").collapse('show');
              }
              $(".submitBtn").attr("data-act","aggiorna").text('aggiorna record');
              $.each(v,function(idx,val){ $('.campo[name='+idx+']').val(val) })
            });
            tr = $("<tr/>").appendTo('.tableWrap>table>tbody')
            $("<td/>",{text:v.cognome}).appendTo(tr)
            $("<td/>",{text:v.nome}).appendTo(tr)
            $("<td/>",{text:v.email}).appendTo(tr)
            $("<td/>",{text:v.indirizzo}).appendTo(tr)
            $("<td/>",{text:v.cellulare}).appendTo(tr)
            $("<td/>",{text:v.fisso}).appendTo(tr)
            $("<td/>",{text:v.note}).appendTo(tr)
            $("<td/>",{html:btn}).appendTo(tr)
          })
          $(".tableWrap>table").removeClass('d-none');
        }
      })
      $('.toggleForm').on('click', function() {
        if ($('#rubricaFormWrap').is(':hidden')) {
          $(this).find('i').toggleClass('fa-angle-down fa-angle-up')
          $("#rubricaFormWrap").collapse('show');
        }else {
          if (!$("input[name=id]").val()) {
            $(this).find('i').toggleClass('fa-angle-up fa-angle-down')
            $("#rubricaFormWrap").collapse('hide');
          }
        }
        $(".submitBtn").attr("data-act","inserisci").text('salva record');
        form[0].reset();
      });
      $(".submitBtn").on('click', function(e){
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault();
          dati = {};
          $(".campo").each(function(index, el) {
            if ($(el).val() || $(el).val()!=='') {dati[$(el).attr('name')]=$(el).val();}
          });
          act = $(this).data('act')
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'global.class.php',classe:'Generica',func:'query'},
              act:{act:act, tab:'rubrica'},
              dati:dati
            }
          })
          .done(function(res) {
            console.log(res);
          })
          .fail(function() { console.log("error"); })
          .always(function() { console.log("complete"); });

        }
      });
    </script>
  </body>
</html>
