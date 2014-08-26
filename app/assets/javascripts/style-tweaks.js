$(function () {
  'use strict';

  var $document = $(document);

  var $backendMenu = $('.backend #menu');
  function backendMenuHeight() {
    $backendMenu.height($document.height());
  }

  backendMenuHeight();
  $(window).on('resize', backendMenuHeight);
});
