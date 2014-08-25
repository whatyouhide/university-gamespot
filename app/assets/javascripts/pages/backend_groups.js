(function () {
  'use strict';

  // Some common callback functions.
  var flashSuccess = function () {
    functions.ajaxFlash('notice', 'Saved');
  };

  // Some common URLs.
  var baseUrl = '/' + config.siteName + '/backend/groups';
  var updateUrl = baseUrl + '/update';
  var createUrl = baseUrl + '/create';

  // Extract data to update a group from a given row.
  var dataFromRow = function ($row) {
    var data = {};

    data.id = $row.attr('data-id');
    data.name = $row.find('td.name').text();

    $row.find('td.permission input[type=checkbox]').each(function () {
      var $input = $(this);
      var permission = $input.attr('name');
      data[permission] = $input.is(':checked');
    });

    return data;
  };

  // Update a group.
  var updateCallback = function () {
    var $button = $(this);
    var $row = $button.parents('tr.group');

    $.post(updateUrl, dataFromRow($row))
      .done(functions.flashSuccessWithMessage('Saved'))
      .fail(functions.flashErrorWithResponseText);
  };

  // Change a group's name.
  var changeName = function () {
    var $cell = $(this).is('td') ? $(this) : $(this).parents('td');
    var $name = $cell.find('span');

    // The input is visible, so don't do anything.
    if ($cell.find('input').length > 0) { return; }

    $name.hide();

    var $newInput = $('<input>')
      .attr('name', 'name')
      .val($name.text());

    $newInput.appendTo($cell);
    $newInput.focus();

    $newInput.on('blur', function () {
      $newInput.remove();
      $name.text($newInput.val());
      $name.show();
    });
  };

  // Add a group.
  var addGroup = function () {
    var $button = $(this);
    var $scope = $button.parents('section.add');
    var $input = $scope.find('input[type=text]');
    var newName = $input.val();

    $.post(createUrl, {name: newName}, function (newGroupId) {
      $input.val('');
      flashSuccess();

      // Build a new row and append it to the table.
      var $newRow = $('tbody tr').first().clone();
      $newRow.find('td.name').text(newName);
      $newRow.attr('data-id', newGroupId);
      $newRow.find('input[type=checkbox]').removeAttr('checked');
      $newRow.appendTo('tbody');
    });
  };

  // The input for the new name changed.
  var addInputChanged = function () {
    var $input = $(this);
    var $button  = $input.parents('section.add').find('[data-add]');

    if ($input.val() === '') {
      $button.attr('disabled', '');
    } else {
      $button.removeAttr('disabled');
    }
  };

  // jQuery ready callback.
  $(function () {
    $(document).on('click', '[data-save]', updateCallback);
    $(document).on('click', 'td.name', changeName);
    $('[data-add]').on('click', addGroup);
    $('section.add input').on('input', addInputChanged);
  });
})();
