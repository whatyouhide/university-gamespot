(function () {
  'use strict';

  var createTagUrl = functions.siteRoot() + '/backend/tags/create';

  // Add a tag to the db through a POST request.
  function addTag(tagName) {
    var promise = $.post(createTagUrl, {name: tagName});
    promise.done(functions.ajaxFlash.bind(this, 'notice', 'Tag created'));
    promise.fail(functions.ajaxFlash.bind(this, 'error', 'Error creating tag'));

    return {
      text: tagName,
      value: tagName
    };
  }

  var staticOptions = {
    create: addTag,
    createOnBlur: true
  };

  $(function () {
    $('[data-selectize]').selectize(staticOptions);
  });
})();

