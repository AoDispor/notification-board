$( document ).ready(function() {

  var numOfZips = 1;

  $('#postal-button').click(function() {
    numOfZips++
    template = $('#zip-template').clone(true,true)
    template.children('label').html('Zip ' + numOfZips)
    template.children('input').attr('name','zip[]')
    template.css("display","none")
    $('#zip-codes').append(template)
    template.slideDown('fast')
  })

});
