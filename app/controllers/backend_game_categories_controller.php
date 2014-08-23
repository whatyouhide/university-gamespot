<?php
/**
 * This file contains the definition of the BackendGameCategoriesController
 * class.
 */

/**
 * A controller for managing game categories in the backend.
 * @package Gamespot
 * @subpackage Controllers
 */
class BackendGameCategoriesController extends BackendController {
  /**
   * GET /game_categories
   * List all the game categories.
   */
  public function index() {
    $this->restrict_to_permission('manage_products');

    $this->game_categories = GameCategory::all();
    $this->render('game_categories/index');
  }

  /**
   * POST /game_categories/create
   * Create a new game category.
   * <b>Ajax</b>
   */
  public function create() {
    $this->restrict_to_permission('manage_products');

    $cat = GameCategory::create(['name' => $this->params['name']]);
    $this->render_plain($cat->id);
  }

  /**
   * POST /game_categories/update?id=1
   * Update a game category.
   * <b>Ajax</b>
   */
  public function update() {
    $this->restrict_to_permission('manage_products');

    $cat = GameCategory::find($this->params['id']);
    $cat->update(['name' => $this->params['name']]);
  }

  /**
   * GET /game_categories/destroy?id=1
   * Destroy a game category.
   * <b>Ajax</b>
   */
  public function destroy() {
    $this->restrict_to_permission('manage_products');

    $cat = GameCategory::find($this->params['id']);
    $cat->destroy();
  }
}
?>
