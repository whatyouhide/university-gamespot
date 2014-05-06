<?php
class GamesController extends Controller {
  // GET /games
  // Display the /games homepage, where there are games divided in a bunch of
  // categories like "Recently added", "Newest" and some others.
  public function index() {
    // Find the three main categories of games.
    $all_games = array(
      'recently_added' => Game::recently_added(),
      'newest' => Game::newest(),
      'with_most_ads' => Game::with_most_ads()
    );

    // Render the template.
    $this->render('games/index', array(
      'all_games' => $all_games
    ));
  }
}
?>
