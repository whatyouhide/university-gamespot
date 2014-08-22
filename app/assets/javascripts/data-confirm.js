$(function () {
  'use strict';

  // The default message for confirmations.
  var DEFAULT_MESSAGE = 'Are you sure?';

  // The target elements.
  var $elements = $('[data-confirm]');

  // Extract the data-confirm message from an element or return the default
  // message if that was empty.
  var extractMessage = function ($el) {
    var msg = $el.attr('data-confirm');
    return (msg === '') ? DEFAULT_MESSAGE : msg;
  }

  // The click callback.
  var callback = function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var $this = $(this);

    // Ask for confirmation.
    var confirmed = confirm(extractMessage($this));

    if (confirmed === true) {
      // Remove this callback and click the original DOM element (otherwise only
      // jQuery click events will be called).
      $this.off('click', callback);
      $this[0].click();
    }
  }

  // Bind the event.
  $elements.on('click', callback);

  // Make a global binding function available.
  window.functions.newDataConfirmElement = function ($el) {
    $el.click(callback);
  };
});
