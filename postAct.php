<?php
session_start();
if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}
switch (true) {
  case $_GET['tipo']=='p':
    $title = 'post';
  break;
  case $_GET['tipo']=='e':
    $title = 'evento';
    $doveInfo = "Inserisci il luogo preciso dell'evento.";
    $tip = '';
  break;
  case $_GET['tipo']=='v':
    $title = 'viaggio';
    $doveInfo = "Inserisci la meta del viaggio.";
    $tip="<i class='far fa-question-circle tip' title='Inserisci la meta del viaggio.<br>Se vuoi creare un percorso, puoi aggiungere le tappe del viaggio' data-placement='top'></i>";
  break;
}
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
      .mainContent .container{min-height:600px;}
      .note-editable p{margin:0 !important;padding: 0 !important;}
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
            <p class="h3">Crea <?php echo $title; ?></p>
            <p class="text-secondary border-bottom ">condividi con i tuoi utenti notizie, articoli o altre informazioni.</p>
            <!-- <form name="postForm" class="form mt-3" action="class/eventAdd.php" method="post" enctype="multipart/form-data"> -->
            <form name="postForm" class="form mt-3" action="postRes.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="act" value="<?php echo $_GET['act']; ?>">
              <input type="hidden" name="tipo" value="<?php echo $_GET['tipo']; ?>">
              <div class="form-group">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="copertina" id="copertina" lang="it">
                    <label class="custom-file-label" for="copertina" data-browse="cerca immagine" lang="it">aggiungi una copertina al tuo <?php echo $title; ?></label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary tip" data-placement="top" type="button" title="Attenzione: puoi caricare immagini jpg, jpeg, png non superiori ai 5MB di dimenioni.<br/>La copertina verrà visualizzata sopra il testo del <?php echo $title; ?>"><i class="fas fa-info"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" id="titolo" name="titolo" class="form-control" placeholder="titolo <?php echo $title; ?>" value="">
              </div>
              <?php if ($_GET['tipo'] !== 'p') {?>
                <div class="form-row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="dove"><?php echo $tip; ?> dove:</label>
                      <input type="text" class="form-control" id="dove" name="dove" value="" placeholder="<?php echo $doveInfo; ?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="da">data inizio:</label>
                      <input type="date" class="form-control" id="da" name="da" value="">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="a">data fine:</label>
                      <input type="date" class="form-control" id="a" name="a" min='' value="" disabled>
                    </div>
                  </div>
                  <?php if ($_GET['tipo'] === 'e') {?>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="a">orario:</label>
                      <input type="time" class="form-control" id="orario" name="orario">
                    </div>
                  </div>
                <?php } ?>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="costo">costo (&euro;):</label>
                      <input type="number" class="form-control" id="costo" name="costo" value="0" min="0" step="0.05">
                    </div>
                  </div>
                </div>
                <?php if ($_GET['tipo'] === 'v') {?>
                <div class="form-row">
                  <div class="col">
                    <div class="form-group">
                      <small>Vuoi aggiungere delle tappe al viaggio? Indica la città, il luogo specifico o l'indirizzo e clicca sul pulsante per aggiungere la tappa.</small>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" id="tappa" placeholder="inserisci tappa" aria-label="inserisci tappa">
                        <div class="input-group-append">
                          <button class="btn btn-secondary" type="button" id="addTappa"><i class="fas fa-plus"></i></button>
                        </div>
                      </div>
                      <div class="tappeWrap">

                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              <?php } ?>
              <div class="form-group">
                <textarea id="summernote" name="testo"></textarea>
              </div>
              <div class="form-group">
                <input type="text" id="tagLista" placeholder="aggiungi tag" class="tm-input form-control form-control-sm w-auto d-inline"/>
                <div class="d-inline-block tagWrap"></div>
              </div>
              <div class="form-group">
                <label><input type="radio" name="bozza" value="true" checked> <strong>salva come bozza:</strong> il <?php echo $title; ?> non sarà visibile finché non deciderai di pubblicarlo</label>
                <label><input type="radio" name="bozza" value="false"> <strong>pubblica direttamente:</strong> il <?php echo $title; ?> sarà subito visibile, potrai comunque modificarlo in un secondo momento</label>
              </div>
              <div class="form-group">
                <label for="">Vuoi aggiungere uno o più allegati?</label>
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
      form = $("form[name=postForm]");
      tipo = $("[name=tipo]").val();
      if (tipo!=='p') {
        $("[name=da]").on('change',function(){
          start = $(this).val()
          if (start) {
            $("[name=a]").prop('disabled',false).attr('min',start).val(start)
          }else {
            $("[name=a]").prop('disabled',true).attr('min','').val('')
          }
        })
      }
      if (tipo === 'v') {
        tappe=[];
        $("#addTappa").on('click',function(){
          tappa = $("#tappa").val();
          if($.inArray(tappa,tappe) === -1){
            tappe.push(tappa)
            group = $("<div/>",{class:'input-group mb-3 tappaItem'}).appendTo('.tappeWrap')
            $("<input/>",{type:'text',class:'form-control'})
            .prop("readonly",true)
            .val(tappa)
            .appendTo(group)
            append = $("<div/>",{class:'input-group-append'}).appendTo(group)
            $("<button/>",{type:"button",class:'btn btn-outline-danger tappaDel'})
              .html('<i class="fas fa-minus"></i>')
              .attr("data-tappa",tappa)
              .appendTo(append)
          }else {
            alert('Attenzione, esiste già una tappa con lo stesso nome')
          }
          $("#tappa").val('').focus();
        })
        $('body').on('click', '.tappaDel', function() {
          tappa = $(this).data('tappa');
          tappe = $.grep(tappe, function(value) { return value != tappa; });
          $(this).closest('.tappaItem').remove()
        });
      }
      $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
      $('#summernote').summernote({
        lang: 'it-IT',
        placeholder: 'Inizia a scrivere qualcosa',
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
        $(".errorMsg").remove();
        e.preventDefault();
        if(!$("#copertina").val()){
          $("#copertina").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg',text:"carica un'immagine"}))
        }else {
          $("#copertina").removeClass('is-invalid').closest('.errorMsg').remove()
        }
        if(!$("#titolo").val()){
          $("#titolo").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg',text:"aggiungi un titolo"}))
        }else {
          $("#titolo").removeClass('is-invalid').closest('.errorMsg').remove()
        }
        if($('#summernote').summernote('isEmpty')) {
          $("#summernote").closest('.form-group').append($("<small/>",{class:'text-danger errorMsg',text:"il testo non può essere vuoto...scrivi qualcosa"}))
        }else {
          $("#summernote").closest('.errorMsg').remove()
        }
        if (!$("[name=tag]").val()) {
          $("#tagLista").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg d-block',text:"Aggiungi almeno una tag! Ricordati di premere 'invio' dopo aver selezionato il termine dalla lista.'"}))
        }else {
          $("#tagLista").removeClass('is-invalid').closest('.errorMsg').remove()
        }
        if (tipo!=='p'){
          if (!$("[name=dove]").val()) {
            $("[name=dove]").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg d-block',text:"Aggiungi un luogo"}))
          }else {
            $("[name=dove]").removeClass('is-invalid').closest('.errorMsg').remove()
          }
          if (!$("[name=da]").val()) {
            $("[name=da]").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg d-block',text:"Aggiungi una data di inizio"}))
          }else {
            $("[name=da]").removeClass('is-invalid').closest('.errorMsg').remove()
          }
          if (!$("[name=a]").val()) {
            $("[name=a]").addClass('is-invalid').closest('.form-group').append($("<small/>",{class:'text-danger errorMsg d-block',text:"Aggiungi una data di fine"}))
          }else {
            $("[name=a]").removeClass('is-invalid').closest('.errorMsg').remove()
          }
        }
        if (tipo === 'v') {
          if(tappe.length > 0){
            $("<input/>",{type:'hidden',name:'tappe'}).val(tappe.join(',')).appendTo(form)
          }
        }
        if ($('.errorMsg').length === 0) { form.submit() }
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
