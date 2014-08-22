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
