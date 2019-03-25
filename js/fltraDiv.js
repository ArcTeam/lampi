if (!RegExp.escape) { RegExp.escape = function (value) { return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&") }; }
var $div = $('.postDiv')
var $filtro = $div.find('.filtro');
$('[name=filtraPost]').keyup(function () {
  var filter = this.value, regex;
  if (filter.length > 2) {
    regex = new RegExp(RegExp.escape(this.value), 'i')
    var $found = $filtro.filter(function () { return regex.test($(this).data('filter')) }).closest('.postDiv').show();
    $div.not($found).hide()
  } else {
    $div.show();
  }
  $("#filterStat").find('span').eq(0).text($(".postDiv:visible").length)
  $("[name=filterReset]").on('click', function(){$("[name=filtraPost]").val('').trigger('keyup');})
});
