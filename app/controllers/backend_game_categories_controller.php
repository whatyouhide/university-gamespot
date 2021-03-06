<?php
/**
 * This file contains the definition of the BackendGameCategoriesController
 * class.
 */

namespace Controllers;

use Models\GameCategory;

/**
 * A controller for managing game categories in the backend.
 */
class BackendGameCategoriesController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all'
  );

  /**
   * GET /game_categories
   * List all the game categories.
   */
  public function index() {
    $this->game_categories = GameCategory::all();
    $this->render('game_categories/index');
  }

  /**
   * POST /game_categories/create
   * Create a new game category.
   * <b>Ajax</b>
   */
  public function create() {
    $cat = GameCategory::create(['name' => $this->params['name']]);

    if ($cat->is_valid()) {
      $this->render_plain($cat->id);
    } else {
      $this->render_error('internal_server_error');
    }
  }

  /**
   * POST /game_categories/update?id=1
   * Update a game category.
   * <b>Ajax</b>
   */
  public function update() {
    $cat = GameCategory::find($this->params['id']);
    $cat->update(['name' => $this->params['name']]);

    if (!$cat->is_valid()) {
      $this->set_status_code(500)->render_plain($cat->errors_as_string());
    }
  }

  /**
   * GET /game_categories/destroy?id=1
   * Destroy a game category.
   * <b>Ajax</b>
   */
  public function destroy() {
    $cat = GameCategory::find($this->params['id']);
    $cat->destroy();
  }

  /**
   * <b>Filter</b>
   * Restrict all the actions of this controller to users with a given
   * permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('manage_products');
  }
}
?>
