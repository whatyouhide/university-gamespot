<?php
/**
 * @package Gamespot
 * @subpackage Controllers
 */
class GamesController extends Controller {
  /**
   * GET /games
   * The games homepage.
   */
  public function index() {
    $all_games = [
      'recently_added' => Game::recently_added(),
      'newest' => Game::newest(),
      'with_most_ads' => Game::with_most_ads()
    ];

    $this->render('games/index', ['all_games' => $all_games]);
  }
}
?>
