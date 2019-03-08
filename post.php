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
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="mainContent">
      <div class="container bg-white p-3">
        <div class="row">
          <div class="col">
            <h3 class="border-bottom">Crea post</h3>
            <form name="postForm" class="form mt-3">
              <div class="form-group">
                <input type="text" name="titoloPost" class="form-control" placeholder="titolo post" value="">
              </div>
              <div class="form-group">
                <textarea id="summernote" name="editordata"></textarea>
              </div>
              <div class="form-group">
                <input type="text" name="tags" placeholder="aggiungi tag" class="tm-input form-control form-control-sm w-auto d-inline"/>
                <div class="d-inline-block tagWrap">

                </div>
              </div>
              <button type="submit" class="btn btn-primary" name="postSaveBtn">salva post</button>
            </form>
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
        $(".mainContent").css({"top" : $(".mainHeader").height() + 3})
        $('#summernote').summernote({
          lang: 'it-IT',
          placeholder: 'Inizia a scrivere il tuo post',
          tabsize: 2,
          height: 300
        });
        $('[name=postForm]').on('submit', function(e) {
          if($('#summernote').summernote('isEmpty')) {
            console.log('contents is empty, fill it!');
            e.preventDefault();
          }else {
            post = $("#summernote").summernote('code')
            console.log(post);
            e.preventDefault();
          }
        })
        tagList(function(tags){
          // console.log(tags);
          // if (tags.length == 0) {
          //   prefilledTags='';
          // }else {
          //   tagsArr = [];
          //   $.each(tags, function(k,v) {tagsArr.push(v.value); });
          //   prefilledTags=tagsArr;
          // }
          $(".tm-input").tagsManager({
            prefilled: '',
            AjaxPush: "inc/addTag.php",
            hiddenTagListName: 'tags',
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
            data: {
              oop:{file:'db.class.php',classe:'Db',func:'tagList'},
            }
          }).done(callback)
        }
    </script>
  </body>
</html>
