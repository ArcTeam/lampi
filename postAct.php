<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
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
      <div class="container bg-white p-3">
        <div class="row" id="postFormWrap">
          <div class="col">
            <p class="h3">Crea post</p>
            <p class="text-secondary border-bottom ">condividi con i tuoi utenti notizie, articoli o altre informazioni. Se vuoi aggiungere un viaggio o un evento utilizza i form dedicati, accessibili dal menù laterale.</p>
            <form name="postForm" class="form mt-3">
              <div class="form-group">
                <input type="text" name="titolo" class="form-control" placeholder="titolo post" value="">
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
              <div class="form-row">
                <div class="col-md-4 mb-3">
                  <button type="submit" class="btn btn-primary btn-sm" name="postSaveBtn">salva modifiche</button>
                  <button type="button" class="btn btn-secondary btn-sm" name="postSaveBtn">annulla inserimento</button>
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
      form = $("form[name=postForm]");
      checkTxt = $("#checkValidation");
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      $('#summernote').summernote({
        lang: 'it-IT',
        placeholder: 'Inizia a scrivere il tuo post',
        tabsize: 2,
        height: 300
      });
      $('[name=postForm]').on('submit', function(e) {
        dati={}
        tagArr={}
        ok = true;
        checkTxt.removeClass().text('')
        e.preventDefault();
        if(!$("[name=titolo]").val()){
          ok= false;
          checkTxt.addClass('text-danger').text('Aggiungi un titolo al post!')
          return false;
        }
        if($('#summernote').summernote('isEmpty')) {
          ok= false;
          checkTxt.addClass('text-danger').text('Devi compilare il testo del post!')
          return false;
        }
        if (!$("[name=tag]").val()) {
          ok=false
          checkTxt.addClass('text-danger').text('Devi aggiungere almeno una tag dalla lista! Ricordati di premere "invio" dopo aver selezionato il termine dalla lista.')
          return false;
        }
        if (ok === true) {
          dati['titolo'] = $("[name=titolo]").val()
          dati['testo'] = $("#summernote").summernote('code')
          dati['tag']=$("[name=tag]").val().split(',');
          dati['bozza'] = $("[name=bozza]:checked").val()
          $.ajax({
            url: connector,
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'eventi.class.php',classe:'Eventi',func:'addPost'},
              dati:dati
            }
          }).done(function(res){
            if (res===true) {
              checkTxt.addClass('text-success').text('Ok, post salvato correttamente')
            }else {
              checkTxt.addClass('text-danger').text('errore nella query:'+res);
            }
          });
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
      // tagList(function(tags){
      //   $(".tm-input").tagsManager({
      //     prefilled: '',
      //     AjaxPush: "inc/addTag.php",
      //     hiddenTagListName: 'tag',
      //     deleteTagsOnBackspace: false,
      //     tagsContainer: '.tagWrap',
      //     tagCloseIcon: '×',
      //   }).autocomplete({source:tags})
      // })
      // function tagList(callback){
      //   $.ajax({
      //     url: connector,
      //     type: 'POST',
      //     dataType: 'json',
      //     data: { oop:{file:'db.class.php',classe:'Db',func:'tagList'} }
      //   }).done(callback)
      // }
    </script>
  </body>
</html>
