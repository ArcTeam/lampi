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
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <?php if(isset($_SESSION['id'])){ ?>
      <div class="px-3 py-2 border-bottom">
        <button type="button" class="btn btn-primary btn-sm toggleForm" ><i class="fas fa-angle-down"></i> crea organigramma</button>
      </div>
      <?php } ?>
      <div class="container-fluid bg-white p-3">
          <div class="row collapse" id="orgFormWrap">
            <div class="col">
              <form name="orgForm" class="formStretto">
                <div class="form-row">
                  <div class="col-xs-12 col-md-6 insertValue">
                    <h5>Seleziona valori</h5>
                    <input type="number" data-campo="anno" name="anno" class="form-control mb-3" min="1993" max="<?php echo date("Y"); ?>" step="1" value="" placeholder="anno inizio mandato" required>
                    <input type="search" data-campo="presidente" class="form-control mb-3 auto" placeholder="presidente">
                    <input type="search" data-campo="vicepresidente" class="form-control mb-3 auto" value="" placeholder="vicepresidente" >
                    <input type="search" data-campo="segretario" class="form-control mb-3 auto" value="" placeholder="segretario" >
                    <input type="search" data-campo="tesoriere" class="form-control mb-3 auto" value="" placeholder="tesoriere" >
                    <input type="search" data-campo="consiglieri" class="form-control mb-3 auto" value="" placeholder="consiglieri" >
                  </div>
                  <div class="col-xs-12 col-md-6 checkField">
                    <h5>Controlla i valori immessi prima di salvare</h5>
                    <input type="text" id="anno" class="form-control mb-3" value="" readonly>
                    <input type="text" id="presidente" class="form-control mb-3" value="" readonly>
                    <input type="text" id="vicepresidente" class="form-control mb-3" value="" readonly>
                    <input type="text" id="segretario" class="form-control mb-3" value="" readonly>
                    <input type="text" id="tesoriere" class="form-control mb-3" value="" readonly>
                  </div>
                </div>
                <div class="form-row d-none outMsg">
                  <div class="col">
                    <div class="alert alert-danger">
                      <p class="m-0text-center">Attenzione! I campi evidenziati in rosso non sono stati compilati correttamente</p>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary submitBtn"></button>
                    <button type="button" class="btn btn-danger deleteBtn d-none" data-toggle="modal" data-target="#delOrg">elimina record</button>
                  </div>
                </div>
                <div class="hiddenValue">
                  <input type="hidden" name="presidente" value="">
                  <input type="hidden" name="vicepresidente" value="">
                  <input type="hidden" name="segretario" value="">
                  <input type="hidden" name="tesoriere" value="">
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
                  <?php if(isset($_SESSION['id'])){ ?>
                  <th scope="col" class="all" width="25px"></th>
                  <?php } ?>
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
      buildTable('buildTable','organigramma_view',function( data ) {
        if (data.length==0) {
          $(".tableWrap>table").addClass('d-none')
        }else {
          $(".tableWrap>p").addClass('d-none')
          data.forEach(function(v,i){
            soci=$.parseJSON(v.cons)
            tdSoci=[]
            $.each(soci, function(k,el){ tdSoci.push(el) })
            tdSociTxt = tdSoci.join(', ');
            btn=$("<button/>",{type:'button',class:'btn btn-outline-info btn-sm'})
            .html("<i class='fas fa-pencil-alt'></i>")
            .on('click',function(){
              $(".checkField > input").css("opacity","1")
              if ($('#orgFormWrap').is(':hidden')) {
                $('.toggleForm').find('i').toggleClass('fa-angle-down fa-angle-up')
                $("#orgFormWrap").collapse('show');
              }
              $(".submitBtn").attr("data-act","aggiorna").text('aggiorna record');
              $("<input/>",{type:'hidden',name:'pk'}).val(v.anno).appendTo('.hiddenValue')
              $("[name=anno],#anno").val(v.anno)
              $("#presidente").val(v.pres)
              $("#vicepresidente").val(v.vicepres)
              $("#segretario").val(v.segr)
              $("#tesoriere").val(v.tes)
              $.each(v,function(idx,val){ $('.hiddenValue').find('[name='+idx+']').val(val)})
              $.each(soci,function(index, el) {
                id = $("<input/>",{type:'hidden',name:'consiglieri', class: 'consigliere'+index }).val(index).appendTo('.hiddenValue')
                div = $("<div/>",{class:'input-group mb-3 consigliere'+index}).appendTo('.checkField')
                $("<input/>",{type:'text', class:'form-control',readonly:'readonly'}).val(el).appendTo(div).css("opacity","1")
                addon = $("<div/>",{class:'input-group-append'}).appendTo(div)
                $("<button/>",{class:'btn btn-danger',type:'button'}).html('<i class="fas fa-times"></i>')
                  .appendTo(addon)
                  .on('click', function() { removeField(index); }
                );
              });
            });
            tr = $("<tr/>").appendTo('.tableWrap>table>tbody')
            $("<td/>",{text:v.anno}).appendTo(tr)
            $("<td/>",{text:v.pres}).appendTo(tr)
            $("<td/>",{text:v.vicepres}).appendTo(tr)
            $("<td/>",{text:v.segr}).appendTo(tr)
            $("<td/>",{text:v.tes}).appendTo(tr)
            $("<td/>",{text:tdSociTxt}).appendTo(tr)
            if ($('body').data('act')=='logged') { $("<td/>",{html:btn}).appendTo(tr) }
          })
          $(".tableWrap>table").removeClass('d-none');
        }
        initTable ([5])
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
        $(".checkField input[readonly]").animate({opacity:0},500)
        $("[name=consiglieri],div[class*=' consigliere']").remove();
        form[0].reset();
        if (!$(".deleteBtn").hasClass('d-none')) {$(".deleteBtn").addClass('d-none')}
      });
      $(".submitBtn").on('click', function(e){
        count=0
        dati={}
        consiglieri=[]
        $(".outMsg").addClass('d-none');
        $(".insertValue [data-campo]").removeClass('is-invalid')
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault();
          check = [];
          check.push($("[name=anno]"))
          $('.hiddenValue>input').each(function(){ check.push($(this)) })
          $(check).each(function(i,v){
            elem = $(this).attr('name')
            if (!$(this).val()) {
              count ++;
              $(".insertValue [data-campo="+elem+"]").addClass('is-invalid')
            }else if ($("[name=consiglieri]").length == 0) {
              $(".insertValue [data-campo=consiglieri]").addClass('is-invalid')
              count ++;
            }else {
              if (elem=='consiglieri') {
                consiglieri.push($(this).val())
              }else {
                dati[elem]=$(this).val()
              }
            }
          })
          dati['consiglieri']=consiglieri
          if (count>0) {
            $(".outMsg").removeClass('d-none').fadeIn(500);
          }else {
            act = $(this).data('act')
            $.ajax({
              url: connector,
              type: 'POST',
              dataType: 'json',
              data: {
                oop:{file:'global.class.php',classe:'Generica',func:'organigramma'},
                act:{act:act, tab:'organigramma'},
                dati:dati
              }
            })
            .done(function(res) {
              if(res === true){
                $('#outPutMsg').html('Ok, il record è stato correttamente modificato!')
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

      $("[name=anno]").on('change',function(){$("#anno").val($(this).val()).animate({opacity:1},500)})
      $( ".auto" ).autocomplete({
        source: "inc/soci_autocomplete.php",
        minLength: 2,
        select: function( event, ui ) {
          campo = $(this).data('campo');
          if (campo == 'consiglieri') {
            if ($(".consigliere"+ui.item.id).length>0) {
              $(this).val('');
              return false;
            }
            id = $("<input/>",{type:'hidden',name:'consiglieri', class: 'consigliere'+ui.item.id }).val(ui.item.id).appendTo('.hiddenValue')
            div = $("<div/>",{class:'input-group mb-3 consigliere'+ui.item.id}).appendTo('.checkField')
            $("<input/>",{type:'text', class:'form-control',readonly:'readonly'}).val(ui.item.value).appendTo(div).animate({opacity:1},500)
            addon = $("<div/>",{class:'input-group-append'}).appendTo(div)
            $("<button/>",{class:'btn btn-danger',type:'button'}).html('<i class="fas fa-times"></i>')
              .appendTo(addon)
              .on('click', function() { removeField(ui.item.id); }
            );
          }else {
            $("[name="+campo+"]").val(ui.item.id)
            $("#"+campo).val(ui.item.value).animate({opacity:1},500)
          }
          $(this).val('');
          return false;
        }
      });
      function removeField(id){$(".consigliere"+id).remove()}
    </script>
  </body>
</html>
