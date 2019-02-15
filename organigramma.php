<?php
session_start();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container-fluid{min-height:600px;}
    </style>
  </head>
  <body>
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="px-3 py-2 border-bottom">
        <button type="button" class="btn btn-primary btn-sm toggleForm" ><i class="fas fa-angle-down"></i> crea organigramma</button>
      </div>
      <div class="container-fluid bg-white p-3">
          <div class="row collapse" id="orgFormWrap">
            <div class="col">
              <form name="orgForm" class="formStretto">
                <div class="form-row">
                  <div class="col col-md-6">
                    <input type="number" name="anno" class="form-control mb-3" min="1993" max="<?php echo date("Y"); ?>" step="2" placeholder="anno inizio mandato" required>
                    <input type="text" name="presidente" class="form-control mb-3" value="" placeholder="presidente" required>
                    <input type="text" name="vicepresidente" class="form-control mb-3" value="" placeholder="vicepresidente" required>
                    <input type="text" name="segretario" class="form-control mb-3" value="" placeholder="segretario" required>
                    <input type="text" name="tesoriere" class="form-control mb-3" value="" placeholder="tesoriere" required>
                    <input type="text" name="consiglieri" class="form-control mb-3" value="" placeholder="consiglieri" required>
                  </div>
                  <div class="col col-md-6">
                    <input type="text" id="anno" class="form-control mb-3" value="" disabled>
                    <input type="text" id="presidente" class="form-control mb-3" value="" disabled>
                    <input type="text" id="vicepresidente" class="form-control mb-3" value="" disabled>
                    <input type="text" id="segretario" class="form-control mb-3" value="" disabled>
                    <input type="text" id="tesoriere" class="form-control mb-3" value="" disabled>
                    <input type="text" id="consiglieri" class="form-control mb-3" value="" disabled>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary submitBtn"></button>
                    <button type="button" class="btn btn-danger deleteBtn d-none" data-toggle="modal" data-target="#delOrg">elimina record</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <div class="row mt-5">
          <div class="col tableWrap">
            <p class="h4 text-center">Nessun organigramma presente</p>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col" class="all"></th>
                  <th scope="col" class="desktop">presidente</th>
                  <th scope="col" class="desktop">vicepresidente</th>
                  <th scope="col" class="desktop">segretario</th>
                  <th scope="col" class="desktop">tesoriere</th>
                  <th scope="col" class="desktop">consiglieri</th>
                  <th scope="col" class="all" width="25px"></th>
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

    <div class="alert outPutMsgAlert" role="alert">
      <p id="outPutMsg" class="text-center"></p>
      <p id="countdowntimer" class="text-center"></p>
    </div>

    <div class="modal fade" id="delOrg" tabindex="-1" role="dialog" aria-labelledby="delOrgLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delOrgLabel">Elimina record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Stai per eliminare l'organigramma del triennio <span id="annoOrg"></span></p>
            <p>Se confermi l'eliminazione i dati non potranno più essere recuperati</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">annulla</button>
            <button type="button" class="btn btn-danger delConfirm">conferma eliminazione</button>
          </div>
        </div>
      </div>
    </div>

    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      form = $("form[name=orgForm]");
      buildTable('buildTable','organigramma',function( data ) {
        if (data.length==0) {
          $(".tableWrap>table").addClass('d-none')
        }else {
          $(".tableWrap>p").addClass('d-none')
          data.forEach(function(v,i){
            btn=$("<button/>",{type:'button',class:'btn btn-outline-info btn-sm'})
            .html("<i class='fas fa-pencil-alt'></i>")
            .on('click',function(){
              if ($('#orgFormWrap').is(':hidden')) {
                $('.toggleForm').find('i').toggleClass('fa-angle-down fa-angle-up')
                $("#orgFormWrap").collapse('show');
              }
              $(".submitBtn").attr("data-act","aggiorna").text('aggiorna record');
              $.each(v,function(idx,val){ $('.campo[name='+idx+']').val(val) })
            });
            tr = $("<tr/>").appendTo('.tableWrap>table>tbody')
            $("<td/>",{text:v.anno}).appendTo(tr)
            $("<td/>",{text:v.presidente}).appendTo(tr)
            $("<td/>",{text:v.vicepresidente}).appendTo(tr)
            $("<td/>",{text:v.segretario}).appendTo(tr)
            $("<td/>",{text:v.tesoriere}).appendTo(tr)
            $("<td/>",{text:v.consiglieri}).appendTo(tr)
            $("<td/>",{html:btn}).appendTo(tr)
          })
          $(".tableWrap>table").removeClass('d-none');
        }
        initTable ([5,6])
      })
      $('.toggleForm').on('click', function() {
        if ($('#orgFormWrap').is(':hidden')) {
          $(this).find('i').toggleClass('fa-angle-down fa-angle-up')
          $("#orgFormWrap").collapse('show');
        }else {
          if (!$("input[name=anno]").val()) {
            $(this).find('i').toggleClass('fa-angle-up fa-angle-down')
            $("#orgFormWrap").collapse('hide');
          }
        }
        $(".submitBtn").attr("data-act","inserisci").text('salva record');
        form[0].reset();
        if (!$(".deleteBtn").hasClass('d-none')) {$(".deleteBtn").addClass('d-none')}
      });
      $(".submitBtn").on('click', function(e){
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault();
          dati = {};
          $(".campo").each(function(index, el) { dati[$(el).attr('name')]=$(el).val(); });
          act = $(this).data('act')
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'global.class.php',classe:'Generica',func:'query'},
              act:{act:act, tab:'organigramma'},
              dati:dati
            }
          })
          .done(function(res) {
            if(res === true){
              $('#outPutMsg').html('Ok, il record è sato correttamente modificato!')
              $("#countdowntimer").text('3')
              $(".outPutMsgAlert").addClass('alert-success').fadeIn(500);
              // countdown(3,window.location.pathname.split('/').pop());
            }else{
              $('#outPutMsg').html('Ops, qualcosa è andato storto!<br>Controlla i dati immessi e riprova,<br>se l\'errore si ripresenta contatta l\'amministratore di sistema<br><a href="mailto:beppenapo@arc-team.com?subject=lampi%bug">beppenapo@arc-team.com</a>')
              $("#countdowntimer").text('5')
              $(".outPutMsgAlert").addClass('alert-danger').fadeIn(500);
              // countdown(5,window.location.pathname.split('/').pop());
            }
          })
          .fail(function() { console.log("error"); })
          .always(function() { console.log("complete"); });
        }
      });
      $('#delOrg').on('show.bs.modal', function (event) {
        anno = $("[name=anno]").val();
        $("#annoOrg").text(anno + " - " + (anno+2).toString())
        $(".delConfirm").on('click',function(){
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'db.class.php',classe:'Db',func:'delOrganigramma'},
              dati:{id:id}
            }
          })
          .done(function(res) {
            if(res === true){
              $('#outPutMsg').html('Ok, il record è stato definitivamente eliminato!')
              $("#countdowntimer").text('3')
              $(".outPutMsgAlert").addClass('alert-success').fadeIn(500);
              // countdown(3,window.location.pathname.split('/').pop());
            }else{
              $('#outPutMsg').html('Ops, qualcosa è andato storto!<br>Controlla i dati immessi e riprova,<br>se l\'errore si ripresenta contatta l\'amministratore di sistema<br><a href="mailto:beppenapo@arc-team.com?subject=lampi%bug">beppenapo@arc-team.com</a>')
              $("#countdowntimer").text('5')
              $(".outPutMsgAlert").addClass('alert-danger').fadeIn(500);
              // countdown(5,window.location.pathname.split('/').pop());
            }
          })
          .fail(function() { console.log("error"); })
          .always(function() { console.log("complete"); });
        })
      })
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      window.addEventListener("orientationchange", function() {
        window.setTimeout(function() { $(".mainContent").css({"top" : $(".mainHeader").height() + 3}) }, 200);
      }, false);


    </script>
  </body>
</html>
