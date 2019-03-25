<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
if (isset($_GET)) { $res=$_GET['res']; }
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
    <input type="hidden" name="resAddPost" value="<?php echo $res; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="container bg-white p-3">
        <div class="row" id="postFormWrap">
          <div class="col">
            <p class="h3">Crea post</p>
            <p class="text-secondary border-bottom ">condividi con i tuoi utenti notizie, articoli o altre informazioni. Se vuoi aggiungere un viaggio o un evento utilizza i form dedicati, accessibili dal menù laterale.</p>
            <form name="postForm" class="form mt-3" action="class/eventAdd.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="act" value="<?php echo $_GET['act']; ?>">
              <input type="hidden" name="tab" value="<?php echo $_GET['tab']; ?>">
              <div class="form-group">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="copertina" id="copertina" lang="it">
                    <label class="custom-file-label" for="copertina" data-browse="cerca immagine" lang="it">aggiungi una copertina al tuo post</label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary tip" data-placement="top" type="button" title="Attenzione: puoi caricare immagini jpg, jpeg, png non superiori ai 5MB di dimenioni.<br/>La copertina verrà visualizzata sopra il testo del post"><i class="fas fa-info"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" id="titolo" name="titolo" class="form-control" placeholder="titolo post" value="">
              </div>
              <div class="form-group">
                <textarea id="summernote" name="testo"></textarea>
              </div>
              <div class="form-group">
                <input type="text" name="tagLista" placeholder="aggiungi tag" class="tm-input form-control form-control-sm w-auto d-inline"/>
                <div class="d-inline-block tagWrap"></div>
              </div>
              <div class="form-group">
                <label><input type="radio" name="bozza" value="true" checked> <strong>salva come bozza:</strong> il post non sarà visibile finché non deciderai di pubblicarlo</label>
                <label><input type="radio" name="bozza" value="false"> <strong>pubblica direttamente:</strong> il post sarà subito visibile, potrai comunque modificarlo in un secondo momento</label>
              </div>
              <div class="form-group">
                <label for="">Vuoi aggiungere uno o più allegati al post?</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="allegati[]" id="allegati" lang="it" multiple="">
                    <label class="custom-file-label" for="allegati" data-browse="carica file" lang="it">carica...</label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary tip" data-placement="top" type="button" title="Attenzione: puoi caricare immagini(jpg,jpeg,png) o pdf di dimensioni non superiori ai 5MB."><i class="fas fa-info"></i></button>
                  </div>
                </div>
                <div class="d-block">
                  <small id="allegatiList">allegati da caricare: </small>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 mb-3">
                  <button type="submit" class="btn btn-primary btn-sm" name="postSaveBtn">salva modifiche</button>
                  <a href="post.php" class="btn btn-secondary btn-sm">annulla inserimento</a>
                </div>
                <div class="col-md-8">
                  <div id="checkValidation"></div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php require('inc/footer.php'); ?>
    </div>
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      if ($("[name=resAddPost]").val()=='ok') {
        alert('Ok, il post è stato correttamente inserito')
        window.location.href="post.php";
      }
      if ($("[name=resAddPost]").val()=='errore') {
        alert('Errore durante l\'inserimento del post. Riprova o contatta l\'amministratore.')
      }
      form = $("form[name=postForm]");
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      $('#summernote').summernote({
        lang: 'it-IT',
        placeholder: 'Inizia a scrivere il tuo post',
        tabsize: 2,
        height: 300,
        dialogsInBody: true
      });
      $("#copertina").on('change', function(event){
        validateFile('copertina',event,'immagine',$(this).val())
      })
      $("#allegati").on('change', function(event){
        check = validateFile('allegati',event,'all',$(this).val())
        if (check === true) {
          input = document.getElementById('allegati')
          list = $('#allegatiList')
          list.find('span').remove();
          for (var x = 0; x < input.files.length; x++) {
            $("<span/>",{class:'font-weight-bold',text:input.files[x].name+" "}).appendTo(list)
          }
        }
      })
      $("[name=postSaveBtn]").on('click', function(e){
        error = false
        $(".errorMsg").remove();
        e.preventDefault();
        if(!$("#copertina").val()){
          $("#copertina").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg',text:"carica un'immagine"}))
          error=true
        }else {
          $("#copertina").removeClass('is-invalid').closest('.errorMsg').remove()
          error=false
        }
        if(!$("#titolo").val()){
          $("#titolo").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg',text:"aggiungi un titolo"}))
          error=true
        }else {
          $("#titolo").removeClass('is-invalid').closest('.errorMsg').remove()
          error=false
        }
        if($('#summernote').summernote('isEmpty')) {
          $("#summernote").closest('.form-group').append($("<small/>",{class:'text-danger errorMsg',text:"il post non può essere vuoto...scrivi qualcosa"}))
          error=true
        }else {
          $("#summernote").closest('.errorMsg').remove()
          error=false
        }
        if (!$("[name=tag]").val()) {
          $("[name=tagLista]").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg d-block',text:"Aggiungi almeno una tag! Ricordati di premere 'invio' dopo aver selezionato il termine dalla lista.'"}))
          error=true
        }else {
          $("[name=tagLista]").removeClass('is-invalid').closest('.errorMsg').remove()
          error=false
        }
        if (error===false) {
          form.submit()
        }
      })

      $(".tm-input").tagsManager({
        prefilled: '',
        AjaxPush: "inc/addTag.php",
        hiddenTagListName: 'tag',
        deleteTagsOnBackspace: false,
        tagsContainer: '.tagWrap',
        tagCloseIcon: '×',
      }).autocomplete({
        source: "json/tags.php",
        minLength:2
      })
    </script>
  </body>
</html>
