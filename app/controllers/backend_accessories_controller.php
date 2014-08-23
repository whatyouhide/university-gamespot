<?php
class BackendAccessoriesController extends BackendController {
  /**
   * GET /accessories
   * List all the accessories.
   */
  public function index() {
    $this->restrict_to_permission('manage_products');

    $this->accessories = Accessory::all();
    $this->render('accessories/index');
  }

  /**
   * GET /accessories/new
   * Render the form for a new accessory.
   */
  public function nuevo() {
    $this->restrict_to_permission('manage_products');

    $this->consoles_for_select = $this->all_consoles_for_select();
    $this->render('accessories/nuevo');
  }

  /**
   * GET /accessories/edit?id=1
   * Edit a accessory.
   */
  public function edit() {
    $this->restrict_to_permission('manage_products');

    $this->accessory = Accessory::find($this->params['id']);
    $this->consoles_for_select = $this->all_consoles_for_select();
    $this->render('accessories/edit');
  }

  /**
   * POST /accessories/create
   * Create a new accessory.
   */
  public function create() {
    $this->restrict_to_permission('manage_products');

    $new_accessory = Accessory::create($this->accessory_params());
    $this->update_accessory_image($new_accessory);

    redirect('/backend/accessories', ['notice' => 'Successfully created.']);
  }

  /**
   * POST /accessories/update?id=1
   * Update an existing accessory.
   */
  public function update() {
    $this->restrict_to_permission('manage_products');

    $accessory = Accessory::find($this->params['id']);
    $accessory->update($this->accessory_params());
    $this->update_accessory_image($accessory);

    redirect('/backend/accessories', ['notice' => 'Successfully updated.']);
  }

  /**
   * GET /accessories/destroy?id=1
   * Destroy a accessory.
   */
  public function destroy() {
    $this->restrict_to_permission('manage_products');

    $accessory = Accessory::find($this->params['id']);
    $accessory->destroy();
    redirect('/backend/accessories', ['notice' => 'Successfully destroyed.']);
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
