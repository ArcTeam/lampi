const observer = lozad('.lozad', { loaded: function(el) { el.classList.add('fadeBg'); } });
const galleryObserver = lozad('.lozadImg', { loaded: function(el) { console.log(el + "loaded"); } });
const connector = "class/connector.php";
observer.observe();
footerMenu();
footerLink();
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
})

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
  $('body').on('click', '[name=addLinkBtn]', function(e){

  })
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
