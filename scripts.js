$( document ).ready(function() {

  var numOfZips = 0;

  $('#postal-button').click(function() {
    numOfZips++
    template = $('#zip-template').clone(true,true)
    template.children('label').html('Zip ' + (numOfZips+1))
    template.children('input').attr('name','postalCodes['+numOfZips+']')
    template.css("display","none")
    $('#zip-codes').append(template)
    template.slideDown('fast')
  })

});
