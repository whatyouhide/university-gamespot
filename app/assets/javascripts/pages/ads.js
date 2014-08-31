$(function () {
  'use strict';

  // Publishing ads.
  var $form = $('form');
  var $hiddenInput = $('input[name=published]', $form);

  $('button[data-hijack]').one('click', function (e) {
    e.preventDefault();
    $hiddenInput.val('1');
    $form.submit();
  });


  // Enabling/disabling <select> tags dynamically when radio buttons change
  // (select by game/accessory).
  var $radioButtons = $('input[type=radio][name=type]');
  var $selects = $('select[name=game], select[name=accessory]');

  var disableSelectBasedOnCheckbox = function () {
    var type = $radioButtons.filter(':checked').val();
    $selects.attr('disabled', '');
    $('select[name=' + type + ']').removeAttr('disabled');
  };

  disableSelectBasedOnCheckbox();
  $radioButtons.change(disableSelectBasedOnCheckbox);
});
