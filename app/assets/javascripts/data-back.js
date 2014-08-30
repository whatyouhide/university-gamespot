$(function () {
  'use strict';

  $('[data-back]').click(function (event) {
    event.preventDefault();
    history.back(-1);
  });
});
