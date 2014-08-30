$(function () {
  'use strict';

  var $table = $('table');
  var $addButton = $('[data-add]');

  var baseUrl = functions.siteRoot() + '/backend/game_categories';
  var createUrl = baseUrl + '/create';
  var destroyUrl = baseUrl + '/destroy';
  var updateUrl = baseUrl + '/update';

  // The input which holds the name of the category to which the $button
  // refers.
  var findAssociatedNameInput = function ($button) {
    return $button.parent().prev().find('input');
  };

  // Create a new category through a POST request.
  var createWithPostRequest = function (categoryName) {
    var promise = $.post(createUrl, {name: categoryName});

    promise.done(function (data) {
      var newId = data;

      // Find a template row.
      var $aRow = $addButton.parents('tr').clone();

      // Remove the 'Add' button.
      $aRow.find('button').remove();

      // Set the input value to the new category name.
      $aRow.find('input').val(categoryName);

      // Set the 'data-id' attribute to the new category id.
      $aRow.attr('data-id', newId);

      var $actionsCell = $aRow.find('td').last();

      // Create the 'Save' and 'Edit' buttons.
      $('<button>')
        .text('Save')
        .attr('data-save', '')
        .appendTo($actionsCell);
      var $destroyButton = $('<button>')
        .text('Destroy')
        .attr('data-destroy', '')
        .attr('data-confirm', '')
        .appendTo($actionsCell);

      functions.newDataConfirmElement($destroyButton);

      $aRow.insertBefore($addButton.parents('tr'));
    });
  };

  // Handle adding categories.
  $addButton.on('click', function (e) {
    var $input = findAssociatedNameInput($addButton);
    createWithPostRequest($input.val());
    $input.val('');
  });

  // Destroy categories.
  $(document).on('click', '[data-destroy]', function (e) {
    var $row = $(e.target).parents('tr');
    var promise = $.get(destroyUrl, {id: $row.attr('data-id')});
    promise.done(function () { functions.ajaxFlash('notice', 'Destroyed'); });
    $row.remove();
  });

  // Save edits to categories.
  $(document).on('click', '[data-save]', function (e) {
    var $clickedButton = $(e.target);
    var $input = findAssociatedNameInput($clickedButton);
    var $row = $clickedButton.parents('tr');

    var promise = $.post(
      updateUrl,
      {id: $row.attr('data-id'), name: $input.val()}
    );

    promise.done(function () { functions.ajaxFlash('notice', 'Saved'); });
    promise.fail(function (promise) {
      functions.ajaxFlash('error', promise.responseText);
    });
  });
});
