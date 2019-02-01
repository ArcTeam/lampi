$(document).ready(function () {
  $(".toggleMenu").on('click',function(e){
    e.preventDefault();
    e.stopPropagation();
    $(".usrMenu").toggleClass('opened closed');
  })
  $(document).on("click", function () {
    if ($('.usrMenu').hasClass('opened')) {  $('.usrMenu').toggleClass('closed opened'); }
  })
})

function countdown(sec,page){
  document.getElementById("countdowntimer").textContent = sec;
  var downloadTimer = setInterval(function(){
    sec--;
    document.getElementById("countdowntimer").textContent = sec;
    if(sec <= 0){ window.location.href=page; }
    // clearInterval(downloadTimer);
  },1000);
}
