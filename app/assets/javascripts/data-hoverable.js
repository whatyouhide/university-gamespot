$(function () {
  'use strict';

  // Return the file extension of a file name (dot included).
  function fileExtension(fileName) {
    return '.' + fileName.split('.').pop();
  }

  function withoutExtension(fileName) {
    return fileName.replace(fileExtension(fileName), '');
  }

  $('img[data-hoverable]').each(function () {
    var $img = $(this);

    var originalSrc = $img.attr('src');
    var hoverSrc = withoutExtension(originalSrc) +
      '-hover' +
      fileExtension(originalSrc);

    $img.hover(function () {
      $(this).attr('src', hoverSrc);
    }, function () {
      $(this).attr('src', originalSrc);
    });
  });
});
