(function () {
  'use strict';

  // Interval between consecutive updates.
  var INTERVAL = 2000;

  // Update an element according to its 'data-ago' HTML attribute.
  var updateElement = function ($el) {
    var time = $el.attr('data-ago');
    var fromNow = moment(time).fromNow();

    $el.text(fromNow);
  };

  // Update all the 'data-ago' elements.
  var updateElements = function ($collection) {
    $collection.each(function () {
      updateElement($(this));
    });
  };

  // jQuery ready.
  $(function () {
    var periodicUpdate = updateElements.bind(this, $('[data-ago]'));

    // Update and then set an interval to update every INTERVAL milliseconds.
    periodicUpdate();
    setInterval(periodicUpdate, INTERVAL);
  });
})();
