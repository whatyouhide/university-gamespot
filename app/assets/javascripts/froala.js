(function () {
  'use strict';

  var staticOptions = {
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
  };

  // jQuery ready event.
  $(function () {
    var $editor = $('.froala');
    var postId = $editor.parents('form').attr('data-post-id');

    var dynamicOptions = {
    };

    $editor.editable(_.merge(staticOptions, dynamicOptions));
  });
})();
