<?php
class Ad extends Model {
  public static $table_name = 'ads';
  public static $key_column = 'id';

  // Fetch all the ads in the database and their associated games.
  public static function all() {
    $all = parent::all();
    return array_map('self::ad_with_associated_game', $all);
  }

  // Find a specific ad based on its id.
  public static function find($id) {
    $ad = parent::find($id);
    if (!$ad) return null;
    return self::ad_with_associated_game($ad);
  }

  // Find the game associated with the given ad.
  private static function ad_with_associated_game($ad) {
    $q = "SELECT *
      FROM `game_ads`
      JOIN `games`
      ON `game_ads`.`game_name` = `games`.`name`
      WHERE `game_ads`.`ad_id` = {$ad['id']}
    ";

    $ad['game'] = self::$db->get_rows($q)[0];
    return $ad;
  }
}

Ad::$db = new DB();
?>
