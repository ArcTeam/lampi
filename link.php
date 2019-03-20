<?php
session_start();
?>

<!doctype html>
<html lang="it">
  <head>
    <?php require('inc/meta.php'); ?>
    <?php require('inc/css.php'); ?>
    <style media="screen">
    .main>.container{min-height: 700px;}
    </style>
  </head>
  <body data-act="<?php echo $_SESSION['act']; ?>">
    <div class="mainHeader bg-white fixed-top">
      <?php require('inc/header.php'); ?>
    </div>
    <div class="main">
      <div class="container bg-white p-3 mt-5">
          <div class="row" id="linkFormWrap">
            <div class="col">
              <form class="form" name="linkForm">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="act" value="inserisci">
                <div class="form-row">
                  <div class="col-md-3">
                    <div class="form-group mb-1">
                      <label for="linkLabel"><small>Inserisci il testo del link</small></label>
                      <input type="text" id="linkLabel" name="label" value="" class="form-control form-control-sm" placeholder="testo" required>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group mb-1">
                      <label for="linkTitle"><small>Inserisci una breve descrizione</small></label>
                      <input type="text" id="linkTitle" name="title" value="" class="form-control form-control-sm" placeholder="breve descrizione" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-1">
                      <label for="linkUrl"><small>Inserisci l'indirizzo</small></label>
                      <div class="input-group input-group-sm mb-3">
                        <input type="url" id="linkUrl" name="url" value="" class="form-control" placeholder="es. http://www.sito.it/" required>
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-primary" id="addLinkBtn" data-act='inserisci'>Salva</button>
                          <button type="button" class="btn btn-secondary" id="resetForm">annulla</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <div class="row mt-5">
          <div class="col tableWrap">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col" class="desktop">testo</th>
                  <th scope="col" class="desktop">descrizione</th>
                  <th scope="col" class="desktop">link</th>
                  <th scope="col" class="desktop"></th>
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
    <?php require('inc/lib.php'); ?>
    <script type="text/javascript">
      form = $("form[name=linkForm]");
      oop = {file:'global.class.php',classe:'Generica',func:'query'}
      $.getJSON('json/link.php',function(data){
        data.forEach(function(v){
          let url = v.url.indexOf('http://') == -1 ? 'http://'+v.url : v.url;
          a = $("<a/>",{href:url, target:'_blank', title:'apri link',class:'tip',text:v.url}).attr("data-placement",'top')
          btnGroup = $("<div/>",{class:'btn-group btn-group-sm',role:"group"})
          $("<button/>",{type:'button',name:'modLink', class:'btn btn-info tip', title:'modifica link'})
          .attr({"data-placement":'top',"data-id":v.id})
          .html('<i class="fas fa-redo"></i>')
          .appendTo(btnGroup)
          .on('click', function(){
            form[0].reset();
            $("[name=id]").val(v.id)
            $("[name=act]").val('modifica')
            $("[name=label]").val(v.label)
            $("[name=title]").val(v.title)
            $("[name=url]").val(url)
          })
          $("<button/>",{type:'button',name:'delLink', class:'btn btn-danger tip', title:'elimina link<br>Attenzione, una volta eliminato il link non sarà più recuperabile'})
          .attr({"data-placement":'top',"data-id":v.id})
          .html('<i class="fas fa-times"></i>')
          .appendTo(btnGroup)
          .on('click', function(){
            let act={};
            let dati={};
            dati['id']=v.id
            act['act']='elimina'
            act['tab']='link'
            process(oop,act,dati)
          })
          tr = $("<tr/>").appendTo('.table>tbody')
          $("<td/>",{text:v.label}).appendTo(tr)
          $("<td/>",{text:v.title}).appendTo(tr)
          $("<td/>",{html:a}).appendTo(tr)
          $("<td/>",{html:btnGroup}).appendTo(tr)
        })
        $('.tip').tooltip({boundary:'window', container:'body', placement:function(tip,element){return $(element).data('placement');}, html:true, trigger:'hover' })
      })
      $("body").on('click',"#addLinkBtn",function(e){
        let act={};
        let dati={};
        isvalidate = form[0].checkValidity();
        if (isvalidate) {
          e.preventDefault()
          if ($("[name=act]").val()==='modifica') { dati['id'] = $("[name=id]").val() }
          dati['label'] = $("[name=label]").val()
          dati['title'] = $("[name=title]").val()
          dati['url'] = $("[name=url]").val()
        }
        act['act']=$("[name=act]").val()
        act['tab']='link'
        process(oop,act,dati)
      })
      $("body").on('click',"#resetForm",function(){
        $("input[name=id]").val('')
        $("input[name=act]").val('inserisci')
        form[0].reset()
      })

      function process(oop,act,dati){
        $.ajax({
          url: connector,
          type: 'POST',
          dataType: 'json',
          data: { oop:oop, act:act, dati:dati}
        })
        .done(function(data) {
          if (act['act']=='inserisci') {
            msg = 'Ok, il link è stato aggiunto correttamente'
          }else if (act['act']=='modifica') {
            msg = 'Ok, il link è stato modificato correttamente'
          }else {
            msg = 'Ok, il link è stato definitivamente eliminato'
          }
          alert(msg)
          location.reload()
        })
        .fail(function(error){
          alert('Attenzione, si è verificato un errore inaspettato, riprova\n '+error)
          location.reload()
        });
      }
    </script>
  </body>
</html>
