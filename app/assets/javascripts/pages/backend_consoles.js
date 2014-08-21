$(function () {
  'use strict';

  $('button[data-hijack]').click(function (e) {
    e.prevendDefault();

    // Empty the file input and submit with an empty value.
    $(this).siblings('[type=file]').val('');
    $(this).parents('form').submit();
  });
});
