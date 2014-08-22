window.functions = {};

// Display a flash on the bottom of the screen.
window.functions.ajaxFlash = function (type, message) {
  // Build the DOM element.
  var $flash = $('<div>')
    .addClass('ajax-flash ' + type)
    .text(message);

  // Append the DOM element to the body.
  $('body').append($flash);

  // Make the DOM element disappear after a while.
  $flash
    .delay(config.flash.ajaxFadeOutAfter)
    .fadeOut(config.flash.ajaxFadeOutIn);
};
