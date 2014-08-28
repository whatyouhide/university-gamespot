<?php
/**
 * This file contains the definition of the GamesController class.
 */

namespace Controllers;

use Models\Game;

/**
 * A controller for managing games.
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
  }
}
?>
