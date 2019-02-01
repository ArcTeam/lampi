$(document).ready(function () {
  var form,oop,dati;
  $('[name=loginBtn]').on('click', function (e) {
    form = $("form[name=loginForm]")
    isvalidate = $(form)[0].checkValidity()
    if (isvalidate) {
      e.preventDefault()
      oop={file:'utente.class.php',classe:'Utente',func:'login'}
      dati={}
      dati.email=$("[name=email]").val()
      dati.pwd=$("[name=pwd]").val()
      $.ajax({
        type: "POST",
        url: "class/connector.php",
        data: {oop:oop, dati:dati},
        dataType: 'json',
        success: function(data){
          if(data.indexOf('Errore!') != -1){
            classe='alert-danger';
            page = 'login.php';
          } else {
            classe='alert-success';
            page = 'index.php';
          }
          $(".outMsg").html(data);
          $(".output").addClass(classe).toggleClass('d-none d-block').fadeIn('fast');
          $("#countdowntimer").text('3');
          countdown(3,page);
        }
      });
    }
  })
  $('[name=rescuePwdBtn]').on('click', function (e) {
    form = $("form[name=rescuePwdForm]")
    isvalidate = $(form)[0].checkValidity()
    if (isvalidate) {
      e.preventDefault()
      oop={file:'utente.class.php',classe:'Utente',func:'rescuePwd'}
      dati={}
      dati.email=$("[name=email]").val()
      $.ajax({
        type: "POST",
        url: "class/connector.php",
        data: {oop:oop, dati:dati},
        dataType: 'json',
        success: function(data){
          if(data.indexOf('Errore!') != -1){
            classe='alert-danger';
            page = 'login.php';
          } else {
            classe='alert-success';
            page = 'index.php';
          }
          $(".outMsg").html(data);
          $(".output").addClass(classe).toggleClass('d-none d-block').fadeIn('fast');
          $("#countdowntimer").text('3');
          countdown(3,page);
        }
      });
    }
  })

  $("[name=toggleRescueForm]").on('click', function() {
    $("[name=rescuePwdForm]").slideToggle('fast')
76  });
})
