<?php
/**
 * This file contains the definition of the GamesController class.
 */

namespace Controllers;

use Models\Game;
use Models\GameNotification;

/**
 * A controller for managing games.
 */
class GamesController extends Controller {
  /**
   * GET /games
   * The games homepage.
   */
  public function index() {
    $this->games = Game::all();
    $this->game_with_most_ads = Game::with_most_ads();
  }

  /**
   * GET /games/subscribe?id=1
   * Subscribe to receive updates about this game and related ads.
   */
  public function subscribe() {
    $game_id = $this->params['id'];
    $created = GameNotification::tie_up_user_and_game(
      $this->current_user->id,
      $game_id
    );

    if ($created) {
      $flash = ['info' => "You'll receive updates when ads about this game are published"];
    } else {
      $flash = ['info' => "You're already subscribed to this game"];
    }

    redirect('/games', $flash);
  }
}
?>
