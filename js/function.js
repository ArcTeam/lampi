$(document).ready(function () {
  $(".toggleMenu").on('click',function(e){
    e.preventDefault();
    $(".usrMenu").toggleClass('opened closed');
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
