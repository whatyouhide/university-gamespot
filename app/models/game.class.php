<?php
class Game extends Model {
  public static function recently_added($limit = 5) {
    $tbl = self::$table_name;
    $q = "SELECT * FROM `games` ORDER BY `added_at` DESC LIMIT $limit";
    return self::$db->get_rows($q);
  }

  public static function newest($limit = 5) {
    $tbl = self::$table_name;
    $q = "SELECT * FROM `games` ORDER BY `release_date` DESC LIMIT $limit";
    return self::$db->get_rows($q);
  }

  public static function with_most_ads($limit = 5) {
    $tbl = self::$table_name;
    $q = "SELECT
      `ads`.`id` AS `ad_id`, `games`.*,
      COUNT(*) `number_of_ads`
      FROM `game_ads`
      JOIN `games` ON `game_ads`.`game_name` = `games`.`name`
      JOIN `ads` ON `game_ads`.`ad_id` = `ads`.`id`
      GROUP BY `game_name`
      ORDER BY `number_of_ads` DESC
      LIMIT $limit
    ";
    return self::$db->get_rows($q);
  }
}

// Initialize some class static attributes.
Game::$db = new DB();
Game::$table_name = 'games';
?>
