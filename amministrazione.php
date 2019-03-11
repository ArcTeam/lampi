<?php
session_start();
require('class/global.class.php');
$class = new Generica;
$tipoArr = $class->tipo_doc();
$table = $class->amministrazione();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container{min-height:600px;}
      .custom-file-label {height: calc(1.8rem + 2px); font-size: 12px; overflow: hidden; line-height: 24px;}
      .custom-file-label::after { height: 1.8rem;font-size: 15px; line-height: 15px;font-family: "FontAwesome"; content: "\f093"; }
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <?php if(isset($_SESSION['id'])){ ?>
      <div class="px-3 py-2 border-bottom">
        <button type="button" class="btn btn-primary btn-sm toggleForm" ><i class="fas fa-angle-down"></i> aggiungi documento</button>
      </div>
      <?php } ?>
      <div class="container bg-white p-3">
          <div class="row collapse" id="formWrap">
            <div class="col">
              <form name="docAmmForm" id="docAmmForm" method="post" enctype="multipart/form-data">
                <h6>Aggiungi un documento alla lista</h6>
                <div class="form-row">
                  <div class="col-md-1 mb-2">
                    <div class="form-group">
                      <label for="anno">Anno:</label>
                      <input type="number" id="anno" name="anno" class="form-control form-control-sm formData" min="1993" max="<?php echo date("Y") + 1; ?>" step="1" value="<?php echo date("Y"); ?>" required>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-group">
                      <label for="categoria">Categoria:</label>
                      <select id="categoria" class="form-control form-control-sm formData" name="categoria" required>
                        <option value="" selected disabled>--scegli categoria--</option>
                        <?php foreach ($tipoArr as $doc) {echo "<option value='".$doc['id']."'>".$doc['tipo']."</option>";} ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 mb-2">
                    <div class="form-group">
                      <label for="entrate">Tot. entrate:</label>
                      <input type="number" id="entrate" class="form-control form-control-sm formData" name="entrate" value="0" min="0" step="0.01" placeholder="entrate" required>
                    </div>
                  </div>
                  <div class="col-md-2 mb-2">
                    <div class="form-group">
                      <label for="uscite">Tot. uscite:</label>
                      <input type="number" id="uscite" class="form-control form-control-sm formData" name="uscite" value="0" min="0" step="0.01" placeholder="uscite" required>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-group">
                      <label for="">Carica pdf:</label>
                      <div class="custom-file">
                        <label class="custom-file-label py-0" for="file">scegli file...</label>
                        <input type="file" class="custom-file-input form-control-sm p-0" name="file" id="file" accept="application/pdf" data-maxsize="10485760" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1 mb-2">
                    <div class="form-group">
                      <label for="" class="text-white">salva</label>
                      <button type="submit" name="submit" class="btn btn-sm btn-primary form-control form-control-sm">salva</button>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <p id="submitMsg"></p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <div class="row mt-1">
          <div class="col tableWrap">
            <table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th>Anno</th>
                  <th>Tipo documento</th>
                  <th>Documento (.pdf)</th>
                  <?php if(isset($_SESSION['id'])){echo "<th></th>";} ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($table as $key => $value) {
                  echo "<tr>";
                  echo "<td>".$value['anno']."</td>";
                  echo "<td>".$value['tipo']."</td>";
                  echo "<td><a href='upload/amministrazione/".$value['file']."' class='tip' data-placement='top' title='apri documento' target='_blank'>".$value['file']." (".$value['size'].")</a></td>";
                  if(isset($_SESSION['id'])){
                    echo "<td><button type='button' class='btn btn-outline-danger btn-sm tip' data-placement='top' name='delDoc' value='".$value['id']."' title='elimina documento' data-toggle='modal' data-target='#delDoc' data-file='".$value['file']."'><i class='fas fa-times'></i></button></td>";
                  }
                  echo "</tr>";
                } ?>
              </tbody>
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

    <div class="modal fade" id="delDoc" tabindex="-1" role="dialog" aria-labelledby="delOrgLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delDocLabel">Elimina record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Stai per eliminare un documento dal database</p>
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
      form = $("form[name=docAmmForm]");
      $('.custom-file-input').on('change',function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
      })
      form.find("input[type=number]").on({
        focus:function(){$(this).val('')},
        blur:function(){$(this).val(0)},
      })
      $('.toggleForm').on('click', function() {
        if ($('#formWrap').is(':hidden')) {
          $(this).find('i').toggleClass('fa-angle-down fa-angle-up')
          $("#formWrap").collapse('show');
        }else {
          $(this).find('i').toggleClass('fa-angle-up fa-angle-down')
          $("#formWrap").collapse('hide');
        }
        $(".submitBtn").attr("data-act","inserisci").text('salva record');
        form[0].reset();
        if (!$(".deleteBtn").hasClass('d-none')) {$(".deleteBtn").addClass('d-none')}
      });
      $("[name=submit]").on('click', function(e){
        $("#submitMsg").removeClass().text('');
        dati={}
        $(".outMsg").addClass('d-none');
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault();
          const tipo = "application/pdf"
          const dim = 10485760
          countError=false
          file=$("input[type=file]").get(0).files[0];
          if (file.type !== tipo) {
            countError=true
            error='attenzione stai cercando di caricare un file '+file.type.split('/').pop()+', puoi caricare solo pdf'
          }
          if (file.size > dim) {
            countError=true
            fileDim = file.size
            realDim = checkDimFile(fileDim,0)
            error='attenzione il file che stai cercando di caricare è di circa '+realDim+' , le dimensioni massime consentite in upload sono di 10MB'
          }
          if (countError) {
            $("#submitMsg").addClass('text-danger text-center').text(error);
          }else {
            datiForm = new FormData();
            $(".formData").each(function(i,v){datiForm.append($(this).attr('name'),$(this).val());});
            datiForm.append("file",file);
            $.ajax({ url: 'class/uploadAmmDoc.php', type: 'POST', dataType: 'json', data: datiForm, contentType: false, processData:false })
              .done(function(data) {
                classe = data.err == 0 ? 'text-success text-center' : 'text-danger text-center';
                $("#submitMsg").addClass(classe).text(data.msg);
                if (data.err == 0) { $("#submitMsg").delay(3000).fadeOut('fast', function(){location.reload()}); }
              });
          }
        }
      });
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      $('#delDoc').on('show.bs.modal', function (event) {
        button = $(event.relatedTarget)
        id = button.val()
        file = button.data('file')
        $(".delConfirm").on('click',function(){
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'global.class.php',classe:'Generica',func:'delAmministrazione'},
              dati:{id:id,file:file}
            }
          })
          .done(function(res) {
            console.log(res);
            if(res === true){
              $('#outPutMsg').html('Ok, il documento è stato definitivamente eliminato!')
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
        })
      })

      window.addEventListener("orientationchange", function() {
        window.setTimeout(function() { $(".mainContent").css({"top" : $(".mainHeader").height() + 3}) }, 200);
      }, false);
    </script>
  </body>
</html>
