<?php
class GamesController extends Controller {

  // GET /games
  public function index() {
    $games_limit = 5;

    // Queries.
    // TODO move these stuff in the Game model.
    $recently_added_games_q = "SELECT * FROM `games`
      ORDER BY `added_at` DESC
      LIMIT $games_limit
    ";
    $newest_games_q = "SELECT * FROM `games`
      ORDER BY `release_date` DESC
      LIMIT $games_limit
    ";
    $games_with_most_ads_q = "SELECT
      `ads`.`id` AS `ad_id`,
      `games`.*,
      COUNT(*) `number_of_ads`
      FROM `game_ads`
      JOIN `games` ON `game_ads`.`game_name` = `games`.`name`
      JOIN `ads` ON `game_ads`.`ad_id` = `ads`.`id`
      GROUP BY `game_name`
      ORDER BY `number_of_ads` DESC
      LIMIT $games_limit
    ";

    $recently_added_games = $this->db->get_rows( $recently_added_games_q );
    $newest_games = $this->db->get_rows( $newest_games_q );
    $games_with_most_ads = $this->db->get_rows( $games_with_most_ads_q );

    $all_games = array(
      'recently-added' => $recently_added_games,
      'newest' => $newest_games,
      'with-most-ads' => $games_with_most_ads
    );

    // Render the template.
    $this->render('games/index', array(
      'recently_added_games' => $recently_added_games,
      'newest_games' => $newest_games,
      'games_with_most_ads' => $games_with_most_ads,
      'all_games' => $all_games
    ));
  }
}
?>
