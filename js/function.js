const observer = lozad('.lozad', { loaded: function(el) { el.classList.add('fadeBg'); } });
const galleryObserver = lozad('.lozadImg', { loaded: function(el) { console.log(el + "loaded"); } });
const connector = "class/connector.php";
observer.observe();
footerMenu();
footerLink();
iscrizioni();
$(document).ready(function () {
  $(".toggleMenu").on('click',function(e){ e.preventDefault(); e.stopPropagation(); $(".usrMenu").toggleClass('opened closed'); })
  $(document).on("click", function () { if ($('.usrMenu').hasClass('opened')) {  $('.usrMenu').toggleClass('closed opened'); } })
  $('.tip').tooltip({boundary:'window', container:'body', placement:function(tip,element){return $(element).data('placement');}, html:true, trigger:'hover' })
  $('[data-toggle="popover"]').popover({
    html: true,
    placement:'bottom',
    content: function () {
      div = $(this).data('id')
      return $(div).html()
    }
  });
  $('.archivioLink').on('click',function(e){sessionStorage.setItem('t',$(this).data('tipo'));})
})

function iscrizioni(){
  $.getJSON('json/iscrizioni.php', function(json, textStatus) {
      $(".iscrizioniLink").append(" ("+json[0]['richieste']+")");
  });
}

function initPost(keywords,limit,tipo,doneCallback){
  option={ url: 'json/post.php', type: 'POST', dataType: 'json', data: {term:keywords,limit:limit,tipo:tipo} }
  return $.ajax( option ).done( doneCallback );
}
function post(post){
  $.ajax({url: connector,type: 'POST', dataType: 'json', data:  {oop: {file:'eventi.class.php',classe:'Eventi',func:'post'}, dati:{post:post}}})
  .done(function(data) {
    console.log(data)
    info = data['info'][0]
    allegati = data['allegati']
    switch (info.tipo) {
      case 'p': tipo = 'post'; break;
      case 'e':
        tipo = 'evento'
        doveTxt = 'Luogo'
        daTxt = 'Inizio'
        daIco = 'fas fa-calendar-alt fa-fw'
        aTxt = 'Fine'
        aIco = 'fas fa-calendar-alt fa-fw'
        orario = data['meta'][0].orario ? data['meta'][0].orario : 'nessun orario specificato'
      break;
      case 'v':
        tipo = 'viaggio'
        doveTxt = 'Destinazione'
        daTxt = 'Partenza'
        daIco = 'fas fa-plane-departure fa-fw'
        aTxt = 'Rientro'
        aIco = 'fas fa-plane-arrival fa-fw'
      break;
    }
    $(".post-banner").css({"background-image":"url('upload/copertine/"+info.copertina+"')"})
    $(".post-titolo").text(info.titolo)
    $("#testo").html(info.testo)
    $(".altre-info>span").text(tipo)
    if (data['meta']) {
      $("#info-div").html("")
      ulMeta = $("<ul/>",{class:'list-group list-group-flush', id:'lista-meta'}).appendTo('#info-div')
      $("<li/>",{class:'list-group-item'})
        .html("<i class='fas fa-map-marker-alt fa-fw'></i><span>"+doveTxt+":</span><span>"+data['meta'][0].dove+"</span>")
        .appendTo(ulMeta)
      $("<li/>",{class:'list-group-item'})
        .html("<i class='"+daIco+"'></i><span>"+daTxt+":</span><span>"+data['meta'][0].da+"</span>")
        .appendTo(ulMeta)
      $("<li/>",{class:'list-group-item'})
        .html("<i class='"+aIco+"'></i><span>"+aTxt+":</span><span>"+data['meta'][0].a+"</span>")
        .appendTo(ulMeta)
        if (info.tipo === 'e') {
          $("<li/>",{class:'list-group-item'})
          .html("<i class='fas fa-clock fa-fw'></i><span>Orario:</span><span>"+orario+"</span>")
          .appendTo(ulMeta)
        }
      $("<li/>",{class:'list-group-item'})
        .html("<i class='fas fa-euro-sign fa-fw'></i><span>Costo:</span><span>&euro; "+data['meta'][0].costo+"</span>")
        .appendTo(ulMeta)
      if (info.tipo === 'v') {
        $("<li/>",{class:'list-group-item'})
        .html("<i class='fas fa-map-pin fa-fw'></i><span>Tappe:</span><span>"+data['meta'][0].tappe.substr(1, data['meta'][0].tappe.length - 2).replace(',',', ')+"</span>")
        .appendTo(ulMeta)
      }
    }
    if (allegati.length > 0) {
      $("#allegati-div").html("")
      ulAllegati = $("<ul/>",{class:'list-group list-group-flush', id:'lista-allegati'}).appendTo('#allegati-div')
      $.each(allegati, function(i,v){
        $("<li/>",{class:'list-group-item'})
          .html("<a href='upload/allegati/"+v.file+"' target='_blank' title='visualizza o scarica allegato'>"+v.file.substr(15)+"</a>")
          .appendTo(ulAllegati)
      })
    }
  })
  .fail(function(xhr, status, error) {
    console.log(error);
  })

}
function buildPostView(data,div){
  $(div).html('')
  const truncate = _.truncate
  data.forEach(function(v,i){
    bozza = v.bozza == false ? 'pubblicato' : 'bozza';
    tags = v.tag.slice(1,-1).split(',')
    let tagsCode=[]
    $.each(tags,function(i,v){
      tagsCode.push("<small class='bg-info rounded text-white p-1 mr-1 mb-1'>"+v.replace(/"/ig,'')+"</small>")
    })
    txt = truncate(v.testo, { 'length': 500, 'separator': ' ','omission': ' [...]'})
    article = $("<article/>",{class:'card rounded-0 animation postDiv'})
    .appendTo(div)
    .hover(function(){ $(this).toggleClass("shadow"); })
    figure = $("<figure/>",{class:'card-title post-banner mb-0 cursor'}).css({"height":"150px", "background-image":'url(upload/copertine/'+v.copertina+')'})
      .appendTo(article)
      .on('click',function(){goPost(v.id)})
    section = $("<section/>", {class:'card-body'}).appendTo(article)
    title = $("<p/>",{class:'post-title cursor', html:v.titolo})
      .appendTo(section)
      .on('click',function(){goPost(v.id)})
    testo = $("<div/>",{class:'post-body text-muted cursor',html:txt})
      .appendTo(section)
      .on('click',function(){goPost(v.id)})

    tags = $("<div/>",{class:'d-block my-2'}).html(tagsCode.join('')).appendTo(section)
    meta = $("<div/>",{class:'d-block my-2'}).html('<small style="font-size:12px;">creato il '+v.data.split(' ')[0]+ " da "+v.email.split('@')[0]+'</small>').appendTo(section)
    if($('body').data('act')){
      usrBtn = $("<div/>",{class:'d-block my-2 text-right btn-group btn-group-sm', role:'group'}).appendTo(section)
      $("<button/>",{type:'button', class:'btn btn-outline-secondary disabled', text:bozza}).appendTo(usrBtn)
      $("<a/>",{href:'postMod.php?r='+v.id, class:'btn btn-warning', text:'modifica'}).appendTo(usrBtn)
      $("<button/>",{type:'button', class:'btn btn-danger', text:'elimina'}).appendTo(usrBtn).on('click',function(){
        delPost = confirm('Attenzione, stai per eliminare un post e tutti i file ad esso collegati.\nSe confermi, i dati non potranno più essere recuperati')
        if (delPost) {
          option={
            url: 'class/connector.php',
            type: 'POST',
            dataType: 'json',
            data: {
              oop:{file:'eventi.class.php',classe:'Eventi',func:'eventiDel'},
              act:{tab:'post'},
              dati:{id:v.id}
            }
          }
          $.ajax( option ).done(function(result){
            initPost('','',sessionStorage.getItem('t'), function(data){
              $("#searchPostRes").find('span').text(data.length)
              buildPostView(data,div)
            })
            alert(result);
          });
        }
      })
    }
  })
}

function goPost(id){
  sessionStorage.setItem('post', id);
  window.location.href='postView.php'
}

function arrayChunk(size,array){
  results = []
  while(array.length > 0){ results.push(array.splice(0, size))}
  return results
}

function validateFile(id,event,tipo,file){
  const maxSize = 5242880 //bytes = 5MB
  size = document.getElementById(id).files[0].size
  mb = formatBytes(size, 0)
  ext = file.split('.').pop().toLowerCase()
  label = tipo == 'all' ? 'carica...' : 'aggiungi una copertina al tuo post';

  if(tipo == 'immagine'){
    if (ext=="jpg" || ext=="jpeg" || ext=="png"){
      $('#'+id).next('.custom-file-label').html(file.split(/(\\|\/)/g).pop());
    }else {
      alert("Attenzione, puoi caricare solo immagini di tipo jpg, jpeg o png!\nStai cercando di caricare un file in formato "+ext);
      event.target.value = '';
      $('#'+id).next('.custom-file-label').html(label);
      return false
    }
  }
  if(tipo == 'pdf'){
    if (ext=="pdf"){
      $('#'+id).next('.custom-file-label').html(file.split(/(\\|\/)/g).pop());
    }else {
      alert("Attenzione, puoi caricare solo documenti in formato pdf!\nStai cercando di caricare un file in formato "+ext);
      event.target.value = '';
      $('#'+id).next('.custom-file-label').html(label);
      return false
    }
  }
  if(tipo == 'all'){
    if (ext=="jpg" || ext=="jpeg" || ext=="png" || ext=="pdf"){
      $('#'+id).next('.custom-file-label').html(label);
      return true
    }else {
      alert("Attenzione, puoi caricare solo immagini (jpg, jpeg, png) o pdf!\nStai cercando di caricare un file in formato "+ext);
      event.target.value = '';
      $('#'+id).next('.custom-file-label').html(label);
      return false
    }
  }
  if (size > maxSize) {
    alert("Attenzione, il file supera le dimensioni massime consentite!\nLe immagini non devono superare i 5MB\nLe dimensioni del file che stai cercando di caricare sono di "+mb)
    $('#'+id).next('.custom-file-label').html(label);
    return false
  }else {
    return true
  }
}
function formatBytes(bytes, decimals) {
    if(bytes== 0){return "0 Byte";}
    var k = 1024;
    var sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB"];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(decimals)) + " " + sizes[i];
}

function initTable (disorder) {
  var cols = !disorder ? [] : disorder
  var t = $('.table').DataTable({
    responsive: true,
    searchHighlight: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Tutti']],
    columnDefs: [{ 'orderable': false, 'targets': cols }],
    language: {
      lengthMenu: "Mostra _MENU_ records",
      search: "",
      emptyTable: "Nessun record presente nel database",
      info: "_START_ / _END_ di _TOTAL_ records",
      infoEmpty: "nessun record corrispondente ai criteri di ricerca",
      infoFiltered: "",
      zeroRecords: "0 record trovati",
      paginate: {
        first:      "prima",
        last:       "ultima",
        next:       "prossima",
        previous:   "precedente"
      }
    }
  })
  t.on( 'draw', function () {
    var body = $( t.table().body() );
    body.unhighlight();
    body.highlight( t.search() );
    $('.tip').tooltip();
  });
  $(".dataTables_filter > label > input").attr('placeholder','cerca record');
}

function countdown(sec,page){
  document.getElementById("countdowntimer").textContent = sec;
  var downloadTimer = setInterval(function(){
    sec--;
    document.getElementById("countdowntimer").textContent = sec;
    if(sec <= 0){ window.location.href=page; }
  },1000);
}
function createSubmenu(){
  var sec=[];
  var $header = $('.header');
  $header.each(function() {
    sec.push($(this).data('ancora'));
    li=$("<li/>",{class:'nav-item'}).appendTo('.submenu>.nav');
    $("<a/>",{class:"nav-link scroll animation",href:"#"+$(this).data('ancora')}).text($(this).find('h3').text().toLowerCase()).appendTo(li);
    scrollSpy(sec);
  });
  $(window).scroll( function() { scrollSpy(sec); });
}
function scrollSpy(sec) {
  sec.forEach(function(v,i){
    w=$(window).scrollTop();
    t=$("#"+v).offset().top - 300;
    if (t <= w) {
      $(".scroll[href='#"+v+"']").addClass('active');
      $(".scroll").not("[href='#"+v+"']").removeClass('active');
    }
  })
}
function wikiApi( endpointUrl, sparqlQuery, doneCallback ) {
  var settings = {
    headers: { Accept: 'application/sparql-results+json' },
    data: { query: sparqlQuery }
  };
  return $.ajax( endpointUrl, settings ).then( doneCallback );
}
function wrapImgWidth(){ $(".imgDiv").height($("#img0").width()) }
function footerMenu(){
  main = $("#navbarNavDropdown>ul>li>a").slice(0, -1)
  main.each(function(i, el) {
    li = $("<li/>",{class:''}).appendTo('.menuFooter');
    $("<a/>",{href:$(this).attr('href')}).text($(this).text()).appendTo(li).on('click', function(event) {
      if ($(this).attr('href')=='#') {
        event.preventDefault();
      }else {
        $(this).prepend('> ')
      }
    });
    ul = $("<ul/>",{class:'pl-3'}).appendTo(li)
    a = $(el).next().find('a.dropdown-item')
    a.each(function(index, v) {
      subLi=$("<li/>").appendTo(ul)
      $("<a/>",{href:$(this).attr('href')}).text('> '+$(this).text()).appendTo(subLi)
    });
  });
}
function footerLink(){
  $.getJSON('json/link.php',function(data){
    data.forEach(function(v,i){
      url = v.url.indexOf('http://') == -1 ? 'http://'+v.url : v.url;
      li=$("<li/>").appendTo('.linkConsigliati');
      $("<a/>",{href:url,title:v.title,target:'_blank',text:'- '+v.label})
      .attr({"data-placement":'left'})
      .appendTo(li)
      .tooltip({boundary:'window', container:'body', placement:'left', html:true, trigger:'hover' })
    })
  });
}

function buildTable(func,tab,callBack){
  option = {
    url: connector,
    type: 'POST',
    dataType: 'json',
    data: {
      oop:{file:'db.class.php',classe:'Db',func:func},
      dati:{tab:tab}
    }
  }
  return $.ajax(option).done(callBack);
}

function checkDimFile(bytes,decimals) {
  if(bytes == 0) return '0 Bytes';
  k = 1024
  dm = decimals <= 0 ? 0 : decimals || 2
  sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
  i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}
function toggleForm(formWrap,btn){
  if ($(formWrap).is(':hidden')) {
    $(btn.target).find('i').toggleClass('fa-angle-down fa-angle-up')
    $(formWrap).collapse('show');
  }else {
    $(btn.target).find('i').toggleClass('fa-angle-up fa-angle-down')
    $(formWrap).collapse('hide');
  }
}
