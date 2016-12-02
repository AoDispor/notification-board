$( document ).ready(function() {

  var numOfZips = 1;

  $('#postal-button').click(function() {
    numOfZips++
    template = $($('#zip-template').html())
    $(template[0]).html('Zip ' + numOfZips)
    $(template[2]).attr('name','zip[]')
    template.css("display","none")
    $('#zip-codes').append(template)
    template.slideDown('fast')
  })

});
