$(function () {
  'use strict';
  var $context = $('body.ads');
  if ($context.length === 0) { return; }

  var $hiddenInput = $('input[name=published]');
  $('button[data-hijack]').click(function (e) {
    e.preventDefault();
    $hiddenInput.val('1');
    $('form').submit();
  });
});
