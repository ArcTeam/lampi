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
        <button type="button" class="btn btn-primary btn-sm toggleForm" ><i class="fas fa-angle-down"></i> aggiungi un nuovo utente</button>
      </div>
      <div class="container-fluid bg-white p-3">
          <div class="row collapse" id="rubricaFormWrap">
            <div class="col">
              <form name="rubricaForm" class="formStretto">
                <input type="hidden" class="campo" name="id" value="">
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cognome" class="">Cognome</label>
                      <input type="text" class="form-control form-control-sm campo" id="cognome" name="cognome" placeholder="Cognome" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nome" class="">Nome</label>
                      <input type="text" class="form-control form-control-sm campo" id="nome" name="nome" placeholder="Nome">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email" class="">Email</label>
                      <input type="email" class="form-control form-control-sm campo" id="email" name="email" placeholder="@Email" required>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="indirizzo" class="">Indirizzo</label>
                      <input type="text" class="form-control form-control-sm campo" id="indirizzo" name="indirizzo" placeholder="Indirizzo">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="cellulare" class="">Cellulare</label>
                      <input type="text" class="form-control form-control-sm campo" id="cellulare" name="cellulare" placeholder="Cellulare">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="fisso" class="">Fisso</label>
                      <input type="text" class="form-control form-control-sm campo" id="fisso" name="fisso" placeholder="Fisso">
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <label for="note" class="">Note</label>
                      <textarea id="note" name="note" class="form-control form-control-sm campo" rows="5" placeholder="note"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary submitBtn"></button>
                    <button type="button" class="btn btn-danger deleteBtn d-none" data-toggle="modal" data-target="#delRubrica">elimina record</button>
                  </div>
                </div>
                <div class="form-row my-3">
                  <div class="col">
                    <div class="alert alert-warning alert-dismissible fade hint" role="alert">
                      <strong>Suggerimento!</strong> Dalla rubrica puoi eliminare tutti i contatti che <strong>non</strong> sono soci o utenti di sistema
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <div class="row mt-5">
          <div class="col tableWrap">
            <p class="h4 d-none text-center">La rubrica è vuota</p>
            <table class="table table-sm d-none">
              <thead>
                <tr>
                  <th scope="col" class="all">cognome</th>
                  <th scope="col" class="all">nome</th>
                  <th scope="col" class="min-tablet">email</th>
                  <th scope="col" class="none">indirizzo</th>
                  <th scope="col" class="min-tablet">cellulare</th>
                  <th scope="col" class="none">fisso</th>
                  <th scope="col" class="all" width="50px">tipo</th>
                  <th scope="col" class="none">note</th>
                  <th class="all" width="25px"></th>
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

    <div class="modal fade" id="delRubrica" tabindex="-1" role="dialog" aria-labelledby="delRubricaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Elimina record dalla rubrica</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Stai per eliminare <span id="utenteRubrica"></span> dai tuoi contatti</p>
            <p>Se confermi l'eliminazione i dati del contatto non potranno più essere recuperati</p>
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
      form = $("form[name=rubricaForm]");
      buildTable('buildTable','rubrica_view',function( data ) {
        if (data.length==0) {
          $(".tableWrap>p").removeClass('d-none');
        }else {
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
              if(!v.socio && !v.utente){$(".deleteBtn").removeClass('d-none')}
              else {$(".deleteBtn").addClass('d-none')}
              if (!$(".alert.hint").hasClass('show')) {$(".alert.hint").addClass('show')}
            });
            tipo='';
            if (v.socio) {tipo += '<i class="fas fa-user-check text-success ml-1 tip" data-toggle="tooltip" data-placement="top" title="socio"></i>';}
            if (v.utente) {tipo += '<i class="fas fa-user-cog text-primary ml-1 tip" data-toggle="tooltip" data-placement="top" title="utente di sistema"></i>';}
            tr = $("<tr/>").appendTo('.tableWrap>table>tbody')
            $("<td/>",{text:v.cognome}).appendTo(tr)
            $("<td/>",{text:v.nome}).appendTo(tr)
            $("<td/>",{text:v.email}).appendTo(tr)
            $("<td/>",{text:v.indirizzo}).appendTo(tr)
            $("<td/>",{text:v.cellulare}).appendTo(tr)
            $("<td/>",{text:v.fisso}).appendTo(tr)
            $("<td/>",{html:tipo}).appendTo(tr)
            $("<td/>",{text:v.note}).appendTo(tr)
            $("<td/>",{html:btn}).appendTo(tr)
          })
          $(".tableWrap>table").removeClass('d-none');
        }
        initTable ([3,4,5,6,7])
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
        $("[name=id]").val('')
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
              act:{act:act, tab:'rubrica'},
              dati:dati
            }
          })
          .done(function(res) {
            if(res === true){
              $('#outPutMsg').html('Ok, il record è sato correttamente modificato!')
              $("#countdowntimer").text('3')
              $(".outPutMsgAlert").addClass('alert-success').fadeIn(500);
              countdown(3,window.location.pathname.split('/').pop());
            }else{
              $('#outPutMsg').html('Ops, qualcosa è andato storto!<br>Controlla i dati immessi e riprova,<br>se l\'errore si ripresenta contatta l\'amministratore di sistema<br><a href="mailto:beppenapo@arc-team.com?subject=lampi%bug">beppenapo@arc-team.com</a>')
              $("#countdowntimer").text('5')
              $(".outPutMsgAlert").addClass('alert-danger').fadeIn(500);
              countdown(5,window.location.pathname.split('/').pop());
            }
          })
          .fail(function() { console.log("error"); })
          .always(function() { console.log("complete"); });
        }
      });
      $('#delRubrica').on('show.bs.modal', function (event) {
        id = $("[name=id]").val();
        nome = $("[name=nome]").val();
        cognome = $("[name=cognome]").val();
        $("#utenteRubrica").text(nome+" "+cognome)
        $(".delConfirm").on('click',function(){
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'db.class.php',classe:'Db',func:'delRubrica'},
              dati:{id:id}
            }
          })
          .done(function(res) {
            if(res === true){
              $('#outPutMsg').html('Ok, il record è stato definitivamente eliminato!')
              $("#countdowntimer").text('3')
              $(".outPutMsgAlert").addClass('alert-success').fadeIn(500);
              countdown(3,window.location.pathname.split('/').pop());
            }else{
              $('#outPutMsg').html('Ops, qualcosa è andato storto!<br>Controlla i dati immessi e riprova,<br>se l\'errore si ripresenta contatta l\'amministratore di sistema<br><a href="mailto:beppenapo@arc-team.com?subject=lampi%bug">beppenapo@arc-team.com</a>')
              $("#countdowntimer").text('5')
              $(".outPutMsgAlert").addClass('alert-danger').fadeIn(500);
              countdown(5,window.location.pathname.split('/').pop());
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
