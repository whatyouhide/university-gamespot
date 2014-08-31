$(function () {
  'use strict';

  var $closedTickets = $('article[data-status=closed]');

  // Hide closed tickets by default.
  $closedTickets.hide();

  $('[data-filter]').click(function (e) {
    e.preventDefault();
    var $target = $(e.target);

    if ($target.is('[data-show-closed]')) {
      $closedTickets.show();
    } else if ($target.is('[data-hide-closed]')) {
      $closedTickets.hide();
    }
  });
});
