$(function () {
  'use strict';

  var $scope = $('.settings');

  if ($scope.length === 0) { return; }

  $('input[type=file]', $scope).on('change', function () {
    var $this = $(this);
    var $submit = $this.siblings('[type=submit]');

    // Disable the submit button if there's no file to upload.
    $submit.attr('disabled', $this.val() === '');
  });
});
