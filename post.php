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
        <a href="postAct.php?act=add&tab=post" class="btn btn-primary btn-sm" >crea post</a>
      </div>
      <?php } ?>
      <div class="container bg-white p-3">
        <div class="row">
          <div class="col">
            <h3 class='text-muted'>Archivio post <span class="badge badge-light float-right"><small><?php echo count($lista); ?> post presenti</small></span></h3>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <table class="table postList">
              <thead class="d-none"><tr><th></th></tr></thead>
              <tbody>
                <?php foreach ($lista as $p) {
                  $usr = explode("@",$p['email']);
                  $tags = preg_replace('/[{|}]/', '',$p['tag']);
                  $tags = explode(',',$tags);
                  $b = $p['bozza'] == true ? '<br/>(articolo in bozza)' : '<br/>(articolo pubblicato)';
                  echo "<tr><td>";
                  echo "<div class='postTitle lozad' data-background-image='upload/copertine/".$p['copertina']."'><div><h1>".$p['titolo']."</h1>";
                  echo "<small class='text-white'>creato il <strong>".explode('.',$p['data'])[0]."</strong> da <strong>".$usr[0]."</strong> ".$b."</small></div></div>";
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
