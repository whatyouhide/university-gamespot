$(function () {
  'use strict';

  $('.froala').editable({
    inlineMode: false,
    buttons: [
      'bold',
      'italic',
      'underline',
      'strikeThrough',
      'formatBlock',
      'blockStyle',
      'align',
      'insertImage',
      'insertOrderedList',
      'insertUnorderedList',
      'selectAll',
      'createLink',
      'undo',
      'redo',
      'html',
      'insertHorizontalRule'
    ]
  });
});
