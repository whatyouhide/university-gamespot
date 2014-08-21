<?php
class BackendConsolesController extends AdminController {
  /**
   * GET /consoles
   * List all the consoles.
   */
  public function index() {
    $this->restrict_to_permission('manage_products');

    $this->consoles = Console::all();
    $this->render('consoles/index');
  }

  /**
   * GET /consoles/new
   * Render the form for a new console.
   */
  public function nuevo() {
    $this->restrict_to_permission('manage_products');

    $this->console = Console::find($this->params['id']);
    $this->render('consoles/nuevo');
  }

  /**
   * GET /consoles/edit?id=1
   * Edit a console.
   */
  public function edit() {
    $this->restrict_to_permission('manage_products');

    $this->console = Console::find($this->params['id']);
    $this->render('consoles/edit');
  }

  /**
   * POST /consoles/create
   * Create a new console.
   */
  public function create() {
    $this->restrict_to_permission('manage_products');

    $new_console = Console::create($this->console_params());
    redirect('/backend/consoles', ['notice' => 'Successfully created.']);
  }

  /**
   * POST /consoles/update?id=1
   * Update an existing console.
   */
  public function update() {
    $this->restrict_to_permission('manage_products');

    $console = Console::find($this->params['id']);
    $console->update($this->console_params());

    redirect('/backend/consoles', ['notice' => 'Successfully updated.']);
  }

  /**
   * GET /consoles/destroy?id=1
   * Destroy a console.
   */
  public function destroy() {
    $this->restrict_to_permission('manage_products');

    $console = Console::find($this->params['id']);
    $console->destroy();
    redirect('/backend/consoles', ['notice' => 'Successfully destroyed.']);
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
}
?>
