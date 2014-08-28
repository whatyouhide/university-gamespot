<?php
/**
 * This file contains the definition of the BackendGamesController class.
 */

namespace Controllers;

use Common\Uploader;
use Models\Game;
use Models\Console;
use Models\GameCategory;
use Models\Upload;

/**
 * A controller for managing games in the backend.
 */
class BackendGamesController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict_permission' => 'all',
    'set_game' => ['edit', 'update', 'destroy']
  );

  /**
   * GET /games
   * List all the games.
   */
  public function index() {
    $this->games = Game::all();
  }

  /**
   * GET /games/new
   * Render the form for a new console.
   */
  public function nuevo() {
    $this->consoles_for_select = $this->all_consoles_for_select();
    $this->game_categories_for_select = $this->all_game_categories_for_select();
  }

  /**
   * GET /games/edit?id=1
   * Edit a console.
   */
  public function edit() {
    $this->consoles_for_select = $this->all_consoles_for_select();
    $this->game_categories_for_select = $this->all_game_categories_for_select();
  }

  /**
   * POST /games/create
   * Create a new console.
   */
  public function create() {
    $new_game = Game::create($this->game_params());

    if ($new_game->is_valid()) {
      $this->update_game_cover_image($new_game);
      redirect('/backend/games', ['notice' => 'Successfully created.']);
    } else {
      redirect('/backend/games/nuevo', [
        'error' => $new_game->errors_as_string()]
      );
    }
  }

  /**
   * POST /games/update?id=1
   * Update an existing console.
   */
  public function update() {
    $this->game->update($this->game_params());

    if ($this->game->is_valid()) {
      $this->update_game_cover_image($this->game);
      redirect('/backend/games', ['notice' => 'Successfully updated.']);
    } else {
      redirect(
        '/backend/games/edit',
        ['error' => $this->game->errors_as_string()],
        ['id' => $this->game->id]
      );
    }
  }

  /**
   * GET /games/destroy?id=1
   * Destroy a console.
   */
  public function destroy() {
    $this->game->destroy();
    redirect('/backend/games', ['notice' => 'Successfully destroyed.']);
  }

  /**
   * Restrict the actions of this controller to a specific permission.
   */
  protected function restrict_permission() {
    $this->restrict_to_permission('manage_products');
  }

  /**
   * Set the `game` instance variable to the Game identified by `id` in the
   * params.
   */
  protected function set_game() {
    $this->game = $this->safe_find_from_id('Game');
  }

  /**
   * Return the parameters needed for updating a console.
   */
  private function game_params() {
    return [
      'name' => $this->params['name'],
      'release_date' => date('Y-m-d', strtotime($this->params['release_date'])),
      'description' => $this->params['description'],
      'software_house' => $this->params['software_house'],
      'console_id' => $this->params['console_id'],
      'game_category_id' => $this->params['game_category_id']
    ];
  }

  /**
   * Update the cover image of a given game.
   * @param Game $game
   */
  private function update_game_cover_image($game) {
    $cover_image = Uploader::get('cover_image');

    if ($cover_image) {
      $upload = Upload::create_from_uploaded_file($cover_image);
      $game->update_cover_image($upload);
    } else {
      $game->update_cover_image(null);
    }
  }

  /**
   * Return all the consoles in a <select>-friendly format.
   * @return array
   */
  private function all_consoles_for_select() {
    $all = Console::all();
    return array_combine(
      array_pluck($all, 'id'),
      array_pluck($all, 'name')
    );
  }

  /**
   * Return all the game categories in a <select>-friendly format.
   * @return array
   */
  private function all_game_categories_for_select() {
    $all = GameCategory::all();
    return array_combine(
      array_pluck($all, 'id'),
      array_pluck($all, 'name')
    );
  }
}
?>
