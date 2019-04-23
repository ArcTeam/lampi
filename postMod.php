<?php
session_start();
require("class/eventi.class.php");
$class = new Eventi;
$itemArr = $class->item($_GET['r']);
$item = $itemArr['info'][0];
$allegati = $itemArr['allegati'];

if (!isset($_SESSION['id'])) {header("Location: login.php"); exit;}

switch (true) {
  case $item['tipo']=='p':
    $title = 'post';
  break;
  case $item['tipo']=='e':
    $title = 'evento';
    $doveInfo = "Modifica il luogo preciso dell'evento.";
    $tip = '';
  break;
  case $item['tipo']=='v':
    $title = 'viaggio';
    $doveInfo = "Modifica la meta del viaggio.";
    $tip="<i class='far fa-question-circle tip' title='Modifica la meta del viaggio.<br>Se vuoi creare un percorso, puoi aggiungere le tappe del viaggio' data-placement='top'></i>";
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
            <p class="h3">Modifica <?php echo $title; ?></p>
            <p class="text-secondary border-bottom ">condividi con i tuoi utenti notizie, articoli o altre informazioni.</p>
            <form name="postForm" class="form mt-3" action="postRes.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="act" value="mod">
              <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">
              <div class="form-group">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="copertina" id="copertina" lang="it">
                    <label class="custom-file-label" for="copertina" data-browse="cerca immagine" lang="it">sostituisci la copertina del tuo <?php echo $title; ?></label>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-secondary tip" data-placement="top" type="button" title="Attenzione: puoi caricare immagini jpg, jpeg, png non superiori ai 5MB di dimenioni.<br/>La copertina verrà visualizzata sopra il testo del <?php echo $title; ?>"><i class="fas fa-info"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" id="titolo" name="titolo" class="form-control" placeholder="titolo <?php echo $title; ?>" value="<?php echo $item['titolo']; ?>">
              </div>
              <?php if ($item['tipo'] !== 'p') {?>
                <div class="form-row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="dove"><?php echo $tip; ?> dove:</label>
                      <input type="text" class="form-control" id="dove" name="dove" placeholder="<?php echo $doveInfo; ?>" value="<?php echo $itemArr['meta'][0]['dove']; ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="da">data inizio:</label>
                      <input type="date" class="form-control" id="da" name="da" value="<?php echo $itemArr['meta'][0]['da']; ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="a">data fine:</label>
                      <input type="date" class="form-control" id="a" name="a" min='' value="<?php echo $itemArr['meta'][0]['a']; ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="costo">costo (&euro;):</label>
                      <input type="number" class="form-control" id="costo" name="costo" value="<?php echo $itemArr['meta'][0]['costo']; ?>" min="0" step="0.05">
                    </div>
                  </div>
                </div>
                <?php if ($item['tipo'] === 'v') {?>
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
                <?php } ?>
              <?php } ?>
              <div class="form-group">
                <textarea id="summernote" name="testo"><?php echo $item['testo']; ?></textarea>
              </div>
              <div class="form-group">
                <input type="text" id="tagLista" placeholder="aggiungi tag" class="tm-input form-control form-control-sm w-auto d-inline"/>
                <div class="d-inline-block tagWrap"></div>
              </div>
              <div class="form-group">
                <label><input type="radio" name="bozza" value="true" <?php if(!empty($item['bozza'])){echo 'checked';} ?>> <strong>salva come bozza:</strong> il <?php echo $title; ?> non sarà visibile finché non deciderai di pubblicarlo</label>
                <label><input type="radio" name="bozza" value="false" <?php if(empty($item['bozza'])){echo 'checked';} ?>> <strong>pubblica direttamente:</strong> il <?php echo $title; ?> sarà subito visibile, potrai comunque modificarlo in un secondo momento</label>
              </div>
              <?php if (count($allegati) > 0) { ?>
                <div class="form-group">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Allegati</li>
                    <?php foreach ($allegati as $k=>$allegato): ?>
                      <li class="list-group-item">
                        <button type="button" class="btn btn-outline-danger btn-sm tip delAllegato" id="allegato<?php echo $k; ?>" title="elimina allegato" data-placement="top" data-post="<?php echo $item['id']; ?>"><i class="fas fa-times"></i></button>
                        <a href="upload/allegati/<?php echo $allegato['file']; ?>" target="_blank" class="tip" data-placement="top" title="visualizza allegato in una nuova scheda"><?php echo substr($allegato['file'],15); ?></a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php } ?>
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

      $(".delAllegato").on('click', function() {
        btn = $(this);
        msg = 'Stai per eliminare un allegato!\nSe confermi il file non potrà più essere recuperato'
        if (confirm(msg)) {
          post = $(this).data('post')
          file = $(this).next('a').attr('href');
          option={
            url: 'class/connector.php',
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'eventi.class.php',classe:'Eventi',func:'delAllegato'},
              dati:{post:post,file:file}
            }
          }
          $.ajax( option ).done(function(result){
            console.log(result)
            btn.closest('li').remove();
          });
        }
      });

      $(".tm-input").tagsManager({
        prefilled: '<?php echo str_replace(array("{","}"),'',$item["tag"]); ?>',
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
