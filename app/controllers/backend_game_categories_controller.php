<?php
class BackendGameCategoriesController extends AdminController {
  public function index() {
    $this->game_categories = GameCategory::all();
    $this->render('game_categories/index');
  }

  public function create() {
    $cat = GameCategory::create(['name' => $this->params['name']]);
    $this->render_plain($cat->id);
  }

  public function update() {
    $cat = GameCategory::find($this->params['id']);
    $cat->update(['name' => $this->params['name']]);
  }

  public function destroy() {
    $cat = GameCategory::find($this->params['id']);
    $cat->destroy();
  }
}
?>
