$(function () {
  'use strict';

  // Initialize some jQuery elements.
  var $document = $(document);
  var $backendMenu = $('.backend #menu');
  var $userActions = $backendMenu.find('.user-actions');

  // Find out some dimensions.
  var menuHeight = $backendMenu.find('h1').height() +
    $backendMenu.find('ul').height();

  var userActionsHeight = $userActions.height();

  function backendMenuHeight() {
    var pageHeight = $document.height();
    // Extend as tall as possible.
    var newHeight = Math.max(pageHeight, menuHeight + userActionsHeight + 50);
    $backendMenu.height(newHeight);
  }

  backendMenuHeight();
  $(window).on('resize', backendMenuHeight);
});
