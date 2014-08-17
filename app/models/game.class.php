<?php
class Game extends Model {
  public static $table_name = 'games';

  // Fetch the most recently added games.
  public static function recently_added($limit = 5) {
    $q = "SELECT * FROM `games` ORDER BY `added_at` DESC LIMIT $limit";
    return self::new_instances_from_query($q);
  }

  // Fetch the most recently released games.
  public static function newest($limit = 5) {
    $q = "SELECT * FROM `games` ORDER BY `release_date` DESC LIMIT $limit";
    return self::new_instances_from_query($q);
  }

  // Fetch the games with most ads.
  public static function with_most_ads($limit = 5) {
    $q = "SELECT
      `ads`.`id` AS `ad_id`, `games`.*,
      COUNT(*) `number_of_ads`
      FROM `game_ads`
      JOIN `games` ON `games_ads`.`game_id` = `games`.`id`
      JOIN `ads` ON `games_ads`.`ad_id` = `ads`.`id`
      GROUP BY `games`.`name`
      ORDER BY `number_of_ads` DESC
      LIMIT $limit
    ";
    return self::new_instances_from_query($q);
  }
}

Game::$db = new DB();
?>
