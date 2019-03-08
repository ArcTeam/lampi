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
              <form name="docAmmForm">
                <h6>Aggiungi un documento alla lista</h6>
                <div class="form-row">
                  <div class="col-md-1 mb-2">
                    <div class="form-group">
                      <label for="anno">Anno:</label>
                      <input type="number" id="anno" name="anno" class="form-control form-control-sm" min="1993" max="<?php echo date("Y") + 1; ?>" step="1" value="<?php echo date("Y"); ?>" required>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-group">
                      <label for="categoria">Categoria:</label>
                      <select id="categoria" class="form-control form-control-sm" name="catDoc" required>
                        <option value="" selected disabled>--scegli categoria--</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 mb-2">
                    <div class="form-group">
                      <label for="entrate">Tot. entrate:</label>
                      <input type="number" id="entrate" class="form-control form-control-sm" name="entrate" value="0" min="0" step="0.01" placeholder="entrate" required>
                    </div>
                  </div>
                  <div class="col-md-2 mb-2">
                    <div class="form-group">
                      <label for="uscite">Tot. uscite:</label>
                      <input type="number" id="uscite" class="form-control form-control-sm" name="uscite" value="0" min="0" step="0.01" placeholder="uscite" required>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-group">
                      <label for="">Carica pdf:</label>
                      <div class="custom-file">
                        <label class="custom-file-label py-0" for="inputGroupFile04">scegli file...</label>
                        <input type="file" class="custom-file-input form-control-sm p-0" id="inputGroupFile04">
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
              </form>
            </div>
          </div>
        <div class="row mt-5">
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

    <div class="modal fade" id="delOrg" tabindex="-1" role="dialog" aria-labelledby="delOrgLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delDocLabel">Elimina record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Stai per eliminare un docuento dal database</p>
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
      $(".submitBtn").on('click', function(e){
        dati={}
        $(".outMsg").addClass('d-none');
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault();
        }
      });
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})

      window.addEventListener("orientationchange", function() {
        window.setTimeout(function() { $(".mainContent").css({"top" : $(".mainHeader").height() + 3}) }, 200);
      }, false);
    </script>
  </body>
</html>
