const observer = lozad('.lozad', { loaded: function(el) { el.classList.add('fadeBg'); } });
const galleryObserver = lozad('.lozadImg', { loaded: function(el) { console.log(el + "loaded"); } });
observer.observe();
$(document).ready(function () {
  $(".toggleMenu").on('click',function(e){
    e.preventDefault();
    e.stopPropagation();
    $(".usrMenu").toggleClass('opened closed');
  })
  $(document).on("click", function () {
    if ($('.usrMenu').hasClass('opened')) {  $('.usrMenu').toggleClass('closed opened'); }
  })
  $('.tip').tooltip({boundary:'window', container:'body', placement:function(tip,element){return $(element).data('placement');}, html:true, trigger:'hover' })
  footerMenu();
})

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
    li = $("<li/>",{class:'list-inline-item align-top'}).appendTo('.menuFooter');
    $("<a/>",{href:$(this).attr('href')}).text($(this).text()).appendTo(li).on('click', function(event) {
      if ($(this).attr('href')=='#') {
        event.preventDefault();
      }else {
        $(this).prepend('> ')
      }
    });
    ul = $("<ul/>").appendTo(li)
    a = $(el).next().find('a.dropdown-item')
    // console.log(a);
    a.each(function(index, v) {
      subLi=$("<li/>").appendTo(ul)
      $("<a/>",{href:$(this).attr('href')}).text('> '+$(this).text()).appendTo(subLi)
    });
  });
}
