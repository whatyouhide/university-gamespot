<?php
/**
 * This file contains the definition of the BackendAccessoriesController class.
 */

namespace Controllers;

use Common\Uploader;
use Models\Accessory;
use Models\Console;
use Models\Upload;

/**
 * A controller to manage accessories in the backend.
 */
class BackendAccessoriesController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all',
    'set_accessory' => ['edit', 'update', 'destroy'],
    'set_consoles_for_select' => ['nuevo', 'edit']
  );

  /**
   * GET /accessories
   * List all the accessories.
   */
  public function index() {
    $this->accessories = Accessory::all();
  }

  /**
   * GET /accessories/new
   * Render the form for a new accessory.
   */
  public function nuevo() {
  }

  /**
   * GET /accessories/edit?id=1
   * Edit a accessory.
   */
  public function edit() {
  }

  /**
   * POST /accessories/create
   * Create a new accessory.
   */
  public function create() {
    $new_accessory = Accessory::create($this->accessory_params());

    if ($new_accessory->is_valid()) {
      $this->update_accessory_image($new_accessory);
      redirect('/backend/accessories', ['notice' => 'Successfully created.']);
    } else {
      redirect('/backend/accessories/nuevo', [
        'error' => $new_accessory->errors_as_string()]
      );
    }
  }

  /**
   * POST /accessories/update?id=1
   * Update an existing accessory.
   */
  public function update() {
    $this->accessory->update($this->accessory_params());

    if ($this->accessory->is_valid()) {
      $this->update_accessory_image($this->accessory);
      redirect('/backend/accessories', ['notice' => 'Successfully updated.']);
    } else {
      redirect(
        '/backend/accessories/edit',
        ['error' => $this->accessory->errors_as_string()],
        ['id' => $this->accessory->id]
      );
    }
  }

  /**
   * GET /accessories/destroy?id=1
   * Destroy a accessory.
   */
  public function destroy() {
    $this->accessory->destroy();
    redirect('/backend/accessories', ['notice' => 'Successfully destroyed.']);
  }

  /**
   * <b>Filter</b>
   * Restrict the access to the actions of this controller only to the users
   * with a specific permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('manage_products');
  }

  /**
   * <b>Filter</b>
   * Safely find the Accessory identified by the id in the params.
   */
  protected function set_accessory() {
    $this->accessory = $this->safe_find_from_id('Accessory');
  }

  /**
   * <b>Filter</b>
   * Set the `consoles_for_select` instance variables.
   */
  protected function set_consoles_for_select() {
    $this->consoles_for_select = $this->all_consoles_for_select();
  }

  /**
   * Return the parameters needed for updating a accessory.
   */
  private function accessory_params() {
    return [
      'name' => $this->params['name'],
      'release_date' => date('Y-m-d', strtotime($this->params['release_date'])),
      'description' => $this->params['description'],
      'producer' => $this->params['producer'],
      'console_id' => $this->params['console_id']
    ];
  }

  /**
   * Update the cover image of a given accessory.
   * @param Accessory $accessory
   */
  private function update_accessory_image($accessory) {
    $image = Uploader::get('image');

    if ($image) {
      $upload = Upload::create_from_uploaded_file($image);
      $accessory->update_image($upload);
    } else {
      $accessory->update_image(null);
    }
  }

  /**
   * Return all the consoles in a <select>-friendly format.
   * @return array
   */
  private function all_consoles_for_select() {
    $consoles = Console::all();

    return array_combine(
      array_pluck($consoles, 'id'),
      array_pluck($consoles, 'name')
    );
  }
}
?>
