<?php
class Ad extends Model {
  // Create a new ad.
  public static function create($attrs) {
    parent::create_record('ads', $attrs);
  }

  // Fetch all the ads in the database and their associated games.
  public static function all() {
    $all = parent::all_the_records('ads');
    return array_map('self::ad_with_associated_game', $all);
  }

  // Find a specific ad based on its id.
  public static function find_by_id($id) {
    $ad = parent::find_unique('ads', 'id', $id);
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
Ad::$table_name = 'ads';
?>
