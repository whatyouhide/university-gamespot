<?php
/**
 * This file contains the definition of the GamesController class.
 */

/**
 * A controller for managing games.
 * @package Gamespot
 * @subpackage Controllers
 */
class GamesController extends Controller {
  /**
   * GET /games
   * The games homepage.
   */
  public function index() {
    $this->all_games = [
      'recently_added' => Game::recently_added(),
      'newest' => Game::newest(),
      'with_most_ads' => Game::with_most_ads()
    ];

    $this->render('games/index');
  }
}
?>
