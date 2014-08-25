window.functions = {};

// Display a flash on the bottom of the screen.
window.functions.ajaxFlash = function (type, message) {
  // Build the DOM element.
  var $flash = $('<div>')
    .addClass('ajax-flash ' + type)
    .text(message)
    .hide();

  // Append the DOM element to the body.
  $flash.appendTo('body').fadeIn(100);

  // Make the DOM element disappear after a while.
  $flash
    .delay(config.flash.ajaxFadeOutAfter)
    .fadeOut(config.flash.ajaxFadeOutIn);
};

// Reload the current page.
window.functions.reload = window.location.reload;

// This callback is used so that a flash error appears on the page, whose
// message is the response text of the server. To be used with jQuery's
// Deferred.fail(), which passes an object that responds to `responseText` to
// its callback.
window.functions.flashErrorWithResponseText = function (response) {
  functions.ajaxFlash('error', response.responseText);
};

// Returns a function that displays a flash notice (success) with a given
// message. This is useful for Deferred.done() callbacks:
//     $.get(...).done(functions.flashSuccessWithMessage('Saved'));
window.functions.flashSuccessWithMessage = function (message) {
  return function () {
    functions.ajaxFlash('notice', message);
  };
};
