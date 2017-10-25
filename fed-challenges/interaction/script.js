var initialDataLoaded = false;
var interactionRef = new Firebase("https://code-challenge-interaction.firebaseio.com/");

var catchInteraction = function (elementId, interactionType) {

  if (elementId) {

      interactionRef.push({
        'element':elementId,
        'interaction':interactionType
      });

    }

}

$(document).ready(function(){

  $('.click').click(function(){
    catchInteraction(this.dataset.interactive, 'clicked');
  });

  $('.doubleClick').dblclick(function(){
    catchInteraction(this.dataset.interactive, 'doubleClicked');
  });

  $('.hover').mouseenter(function(){
    catchInteraction(this.dataset.interactive, 'hovered');
  });

  interactionRef.on('child_added', function(snapshot) {

    if (!initialDataLoaded) return;

    var elementId = snapshot.val().element;
    var classToAdd = snapshot.val().interaction;

    var interactedElement = $('*[data-interactive="'+elementId+'"]')

    $(interactedElement).addClass(classToAdd);

    setTimeout(function(){

      $(interactedElement).removeClass(classToAdd);

    }, 1000);

  });

  interactionRef.once('value', function(snapshot) {

    initialDataLoaded = true;

  });

});
