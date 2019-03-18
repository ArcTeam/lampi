<?php
session_start();
require('class/eventi.class.php');
$post = new Eventi;
$bozza = !isset($_SESSION['id']) ? 'f' : null;
$lista = $post->postList(null,$bozza, null);

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
      <?php if(isset($_SESSION['id'])){ ?>
      <div class="px-3 py-2 border-bottom">
        <button type="button" class="btn btn-primary btn-sm toggleForm" ><i class="fas fa-angle-down"></i> crea post</button>
      </div>
      <?php } ?>
      <div class="container bg-white p-3">
        <?php if(isset($_SESSION['id'])){ ?>
        <div class="row collapse" id="postFormWrap">
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
        <?php } ?>
        <div class="row">
          <div class="col">
            <h3 class='text-muted'>Archivio post <span class="badge badge-light float-right"><small><?php echo count($lista); ?> post presenti</small></span></h3>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <table class="table">
              <thead class="d-none"><tr><th></th></tr></thead>
              <tbody>
                <?php foreach ($lista as $p) {
                  $usr = explode("@",$p['email']);
                  $tags = preg_replace('/[{|}]/', '',$p['tag']);
                  $tags = explode(',',$tags);
                  $b = $p['bozza'] == true ? '<span class="float-right badge badge-warning"><small>bozza</small></span>' : '<span class="float-right badge badge-success"><small>pubblicato</small></span>';
                  echo "<tr><td>";
                  echo "<h3 class='mb-0 postTitle'>".$p['titolo'].$b."</h3>";
                  echo "<small>creato il <strong>".$p['data']."</strong> da <strong>".$usr[0]."</strong></small>";
                  echo "<div class='mt-3'>".$post->truncate($p['testo'], 2000, array('html' => true, 'ending' => '...'))."</div>";
                  echo "<div class='w-75 d-inline-block'>";
                  foreach ($tags as $tag) {
                    echo "<span class='bg-info px-1 mr-1 mb-1 rounded text-white'><small>".$tag."</small></span>";
                  }
                  echo "</div>";
                  echo "<div class='w-25 d-inline-block'>";
                  echo "<button type='button' class='btn btn-sm btn-primary float-right' data-post='".$p['id']."'>modifica</button>";
                  echo "</div>";
                  echo "</td></tr>";
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

    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      form = $("form[name=postForm]");
      $('.toggleForm').on('click', function(e) {
        toggleForm('#postFormWrap',e)
        // $(".submitBtn").attr("data-act","inserisci").text('salva record');
        // form[0].reset();
        // if (!$(".deleteBtn").hasClass('d-none')) {$(".deleteBtn").addClass('d-none')}
      });
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
      tagList(function(tags){
        $(".tm-input").tagsManager({
          prefilled: '',
          AjaxPush: "inc/addTag.php",
          hiddenTagListName: 'tag',
          deleteTagsOnBackspace: false,
          tagsContainer: '.tagWrap',
          tagCloseIcon: '×',
        }).autocomplete({source:tags})
      })
      function tagList(callback){
        $.ajax({
          url: connector,
          type: 'POST',
          dataType: 'json',
          data: { oop:{file:'db.class.php',classe:'Db',func:'tagList'} }
        }).done(callback)
      }
    </script>
  </body>
</html>
