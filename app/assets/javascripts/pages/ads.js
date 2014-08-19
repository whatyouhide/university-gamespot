$(function () {
  'use strict';

  var $form = $('form');
  var $hiddenInput = $('input[name=published]', $form);

  $('button[data-hijack]').one('click', function (e) {
    e.preventDefault();
    $hiddenInput.val('1');
    $form.submit();
  });
});
