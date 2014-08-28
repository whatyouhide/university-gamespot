<?php
/**
 * This file contains the definition of the BackendConsolesController class.
 */

namespace Controllers;

use Session;
use Models\Console;
use Models\Upload;

/**
 * A controller to manage consoles.
 */
class BackendConsolesController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all',
    'set_console' => ['edit', 'update', 'destroy']
  );

  /**
   * GET /consoles
   * List all the consoles.
   */
  public function index() {
    $this->consoles = Console::all();
  }

  /**
   * GET /consoles/new
   * Render the form for a new console.
   */
  public function nuevo() {
  }

  /**
   * GET /consoles/edit?id=1
   * Edit a console.
   */
  public function edit() {
  }

  /**
   * POST /consoles/create
   * Create a new console.
   */
  public function create() {
    $new_console = Console::create($this->console_params());

    if ($new_console->is_valid()) {
      $this->update_console_image($new_console);
      redirect('/backend/consoles', ['notice' => 'Successfully created.']);
    } else {
      Session::flash('error', $new_console->errors_as_string());
      $this->render('consoles/nuevo');
    }
  }

  /**
   * POST /consoles/update?id=1
   * Update an existing console.
   */
  public function update() {
    $this->console->update($this->console_params());

    if ($this->console->is_valid()) {
      $this->update_console_image($this->console);
      redirect('/backend/consoles', ['notice' => 'Successfully updated.']);
    } else {
      Session::flash('error', $this->console->errors_as_string());
      $this->render('consoles/edit');
    }
  }

  /**
   * GET /consoles/destroy?id=1
   * Destroy a console.
   */
  public function destroy() {
    $this->console->destroy();
    redirect('/backend/consoles', ['notice' => 'Successfully destroyed.']);
  }

  /**
   * <b>Filter</b>
   * Restrict the actions of this controller to a specific permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('manage_products');
  }

  /**
   * <b>Filter</b>
   * Set the `console` instance variable.
   */
  protected function set_console() {
    $this->console = $this->safe_find_from_id('Console');
  }

  /**
   * Return the parameters needed for updating a console.
   */
  private function console_params() {
    return [
      'name' => $this->params['name'],
      'producer' => $this->params['producer'],
      'release_year' => $this->params['release_year']
    ];
  }

  /**
   * Update the image of a given console.
   * @param Console $console
   */
  private function update_console_image($console) {
    $img = isset($_FILES['console_image']) ? $_FILES['console_image'] : null;
    $empty_img = !$img || empty($img['name']);

    if (!$empty_img) {
      $upload = Upload::create_from_uploaded_file($img);
      $console->update_image($upload);
    } else if ($empty_img && $console->image) {
      $console->delete_image();
    }
  }
}
?>
