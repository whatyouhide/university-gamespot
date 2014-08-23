<?php
class BackendGameCategoriesController extends BackendController {
  public function index() {
    $this->restrict_to_permission('manage_products');

    $this->game_categories = GameCategory::all();
    $this->render('game_categories/index');
  }

  public function create() {
    $this->restrict_to_permission('manage_products');

    $cat = GameCategory::create(['name' => $this->params['name']]);
    $this->render_plain($cat->id);
  }

  public function update() {
    $this->restrict_to_permission('manage_products');

    $cat = GameCategory::find($this->params['id']);
    $cat->update(['name' => $this->params['name']]);
  }

  public function destroy() {
    $this->restrict_to_permission('manage_products');

    $cat = GameCategory::find($this->params['id']);
    $cat->destroy();
  }
}
?>
